"""Donations Router — donasi + Midtrans webhook"""

import uuid
import hashlib
from datetime import datetime
from fastapi import APIRouter, Request, Depends, HTTPException, Query
from pydantic import BaseModel

from app.models.donasi import Donasi
from app.models.program import Program
from app.services.midtrans import MidtransService
from app.services.email import EmailService
from app.services.ledger import LedgerService
from app.middleware.audit import log_audit
from app.middleware.rate_limit import limiter
from app.config import settings

router = APIRouter(prefix="/api/donations", tags=["Donations"])


class DonationRequest(BaseModel):
    program_id: str
    jumlah: float
    nama: str | None = None
    email: str | None = None
    no_hp: str | None = None
    kecamatan: str | None = None
    kabupaten: str | None = None
    provinsi: str | None = None
    is_anonim: bool = False
    metode_pembayaran: str = "transfer"


class DonationResponse(BaseModel):
    order_id: str
    token: str | None = None
    redirect_url: str | None = None


# ── Public endpoints ──────────────────────

@router.post("", response_model=DonationResponse)
@limiter.limit("10/minute")
async def create_donation(request: Request, data: DonationRequest):
    """Buat donasi baru → dapatkan Midtrans Snap token"""
    # Validate program
    program = await Program.get(data.program_id)
    if not program or not program.is_active:
        raise HTTPException(status_code=404, detail="Program tidak ditemukan")

    # Generate order ID
    order_id = f"BM-{uuid.uuid4().hex[:10].upper()}"

    # Get Midtrans Snap token
    try:
        midtrans_result = await MidtransService.create_transaction(
            order_id=order_id,
            gross_amount=data.jumlah,
            customer_name=data.nama or "Donatur",
            customer_email=data.email or "donatur@bantumereka.org",
            customer_phone=data.no_hp or "",
            program_name=program.nama,
        )
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Gagal membuat transaksi: {str(e)}")

    # Save donation record
    donasi = Donasi(
        program_id=data.program_id,
        nama=data.nama,
        email=data.email,
        no_hp=data.no_hp,
        kecamatan=data.kecamatan,
        kabupaten=data.kabupaten,
        provinsi=data.provinsi,
        jumlah=data.jumlah,
        metode_pembayaran=data.metode_pembayaran,
        is_anonim=data.is_anonim,
        midtrans_order_id=order_id,
        midtrans_token=midtrans_result.get("token"),
        midtrans_redirect_url=midtrans_result.get("redirect_url"),
    )
    await donasi.insert()

    # Audit log
    await log_audit(request, "donasi_created", "donasi", str(donasi.id))

    return DonationResponse(
        order_id=order_id,
        token=midtrans_result.get("token"),
        redirect_url=midtrans_result.get("redirect_url"),
    )


@router.post("/webhook")
async def midtrans_webhook(request: Request):
    """Webhook Midtrans — dipanggil setelah pembayaran selesai"""
    payload = await request.json()

    order_id = payload.get("order_id", "")
    transaction_status = payload.get("transaction_status", "")
    fraud_status = payload.get("fraud_status", "")
    signature_key = payload.get("signature_key", "")
    gross_amount = str(payload.get("gross_amount", "0"))
    status_code = str(payload.get("status_code", "200"))

    # Verify signature
    if not MidtransService.verify_signature_key(
        order_id, status_code, gross_amount, signature_key
    ):
        raise HTTPException(status_code=403, detail="Invalid signature")

    # Find donation
    donasi = await Donasi.find_one({"midtrans_order_id": order_id})
    if not donasi:
        raise HTTPException(status_code=404, detail="Order tidak ditemukan")

    # Update status based on Midtrans response
    if transaction_status in ("capture", "settlement"):
        if fraud_status == "accept":
            donasi.status = "berhasil"
            donasi.midtrans_transaction_id = payload.get("transaction_id", "")
            donasi.midtrans_payment_type = payload.get("payment_type", "")
            donasi.midtrans_va_number = payload.get("va_numbers", [{}])[0].get("va_number", "") if payload.get("va_numbers") else ""

            # Compute ledger hash
            prev = await Donasi.find_one(
                {"program_id": donasi.program_id, "status": "berhasil", "ledger_hash": {"$ne": None}}
            ).sort("-created_at")
            prev_hash = prev.ledger_hash if prev else "0" * 64
            donasi.ledger_prev_hash = prev_hash
            donasi.ledger_hash = LedgerService.compute_chained_hash(
                prev_hash,
                {"order_id": order_id, "jumlah": donasi.jumlah, "program_id": donasi.program_id},
            )

            # Update program stats
            program = await Program.get(donasi.program_id)
            if program:
                program.total_terkumpul += donasi.jumlah
                program.jumlah_donatur += 1
                await program.save()

            # Send receipt email
            if donasi.email:
                await EmailService.send_donation_receipt(
                    to_email=donasi.email,
                    to_name=donasi.nama or "Donatur",
                    program_name=program.nama if program else "Program",
                    amount=donasi.jumlah,
                    order_id=order_id,
                    payment_method=donasi.midtrans_payment_type or donasi.metode_pembayaran,
                    donation_date=donasi.created_at.strftime("%d %B %Y"),
                )

        elif fraud_status == "deny":
            donasi.status = "gagal"

    elif transaction_status in ("deny", "cancel", "expire"):
        donasi.status = "gagal"
    elif transaction_status == "pending":
        donasi.status = "pending"

    donasi.updated_at = datetime.utcnow()
    await donasi.save()

    # Audit log
    await log_audit(request, f"donasi_{donasi.status}", "donasi", str(donasi.id))

    return {"status": "ok"}


@router.get("/history")
async def donation_history(
    email: str = Query(...),
    page: int = Query(1, ge=1),
    limit: int = Query(10, ge=1, le=50),
):
    """Riwayat donasi berdasarkan email donatur"""
    donations = Donasi.find({"email": email}).sort("-created_at")
    total = await donations.count()
    items = await donations.skip((page - 1) * limit).limit(limit).to_list()

    result = []
    for d in items:
        program = await Program.get(d.program_id)
        result.append({
            "id": str(d.id),
            "program_id": d.program_id,
            "program_nama": program.nama if program else "-",
            "jumlah": d.jumlah,
            "status": d.status,
            "metode_pembayaran": d.metode_pembayaran,
            "midtrans_order_id": d.midtrans_order_id,
            "created_at": d.created_at.isoformat(),
        })

    return {"data": result, "total": total, "page": page}
