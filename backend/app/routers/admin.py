"""Admin Router — Dashboard admin, transparansi, withdrawal"""

from typing import Optional
from fastapi import APIRouter, Request, Depends, HTTPException, Query
from pydantic import BaseModel
from datetime import datetime

from app.models.program import Program
from app.models.donasi import Donasi
from app.models.relawan import Relawan
from app.models.laporan import LaporanBantuan
from app.models.withdrawal import Withdrawal, DistributionActivity, DistributionRecipient
from app.models.user import User
from app.models.team import Team, Partner, Bank, WhatsappGroup
from app.models.audit import AuditLog
from app.utils.auth import get_admin_user
from app.services.ledger import LedgerService
from app.middleware.audit import log_audit

router = APIRouter(prefix="/api/admin", tags=["Admin"])


# ── Dashboard ────────────────────────────

@router.get("/dashboard")
async def admin_dashboard(user: User = Depends(get_admin_user)):
    """Admin dashboard stats"""
    return {
        "total_program": await Program.find().count(),
        "total_program_aktif": await Program.find({"is_active": True}).count(),
        "total_donasi": await Donasi.find().count(),
        "total_donasi_berhasil": await Donasi.find({"status": "berhasil"}).count(),
        "total_relawan": await Relawan.find().count(),
        "total_relawan_pending": await Relawan.find({"admin_status": "baru"}).count(),
        "total_laporan": await LaporanBantuan.find().count(),
        "total_laporan_pending": await LaporanBantuan.find({"admin_status": "baru"}).count(),
        "total_donasi_amount": await Donasi.aggregate([
            {"$match": {"status": "berhasil"}},
            {"$group": {"_id": None, "total": {"$sum": "$jumlah"}}}
        ]).to_list(),
    }


# ── Relawan Dashboard ────────────────────

@router.get("/relawan")
async def admin_relawan(
    page: int = Query(1, ge=1),
    limit: int = Query(20, le=100),
    status: Optional[str] = None,
    user: User = Depends(get_admin_user),
):
    """Admin: List relawan dengan filter"""
    query = {}
    if status:
        query["admin_status"] = status

    items = Relawan.find(query).sort("-created_at")
    total = await items.count()
    data = await items.skip((page - 1) * limit).limit(limit).to_list()

    return {
        "data": [{**r.dict(), "id": str(r.id)} for r in data],
        "total": total,
        "page": page,
    }


# ── Laporan Dashboard ────────────────────

@router.get("/laporan")
async def admin_laporan(
    page: int = Query(1, ge=1),
    limit: int = Query(20, le=100),
    status: Optional[str] = None,
    user: User = Depends(get_admin_user),
):
    """Admin: List laporan dengan filter"""
    query = {}
    if status:
        query["admin_status"] = status

    items = LaporanBantuan.find(query).sort("-created_at")
    total = await items.count()
    data = await items.skip((page - 1) * limit).limit(limit).to_list()

    return {
        "data": [{**l.dict(), "id": str(l.id)} for l in data],
        "total": total,
        "page": page,
    }


# ── Withdrawal (Pencairan Dana) ──────────

class WithdrawalCreate(BaseModel):
    program_id: str
    jumlah: float
    milestone_id: Optional[str] = None
    keterangan: Optional[str] = None


@router.post("/withdrawals")
async def create_withdrawal(
    request: Request,
    data: WithdrawalCreate,
    user: User = Depends(get_admin_user),
):
    """Admin: Buat pencairan dana"""
    program = await Program.get(data.program_id)
    if not program:
        raise HTTPException(status_code=404, detail="Program tidak ditemukan")

    # Get prev hash for ledger
    prev = await Withdrawal.find_one(
        {"program_id": data.program_id, "ledger_hash": {"$ne": None}}
    ).sort("-created_at")
    prev_hash = prev.ledger_hash if prev else "0" * 64

    withdrawal = Withdrawal(
        program_id=data.program_id,
        jumlah=data.jumlah,
        milestone_id=data.milestone_id,
        keterangan=data.keterangan,
        status="pending",
        approved_by=str(user.id),
        approved_at=datetime.utcnow(),
    )

    # Compute ledger hash
    withdrawal.ledger_prev_hash = prev_hash
    withdrawal.ledger_hash = LedgerService.compute_chained_hash(
        prev_hash,
        {"type": "withdrawal", "program_id": data.program_id, "jumlah": data.jumlah},
    )

    await withdrawal.insert()

    # Update program stats
    program.total_disalurkan += data.jumlah
    await program.save()

    await log_audit(request, "withdrawal_created", "withdrawal", str(withdrawal.id))

    return {"message": "Pencairan berhasil dibuat", "id": str(withdrawal.id)}


@router.get("/withdrawals")
async def list_withdrawals(
    program_id: Optional[str] = None,
    user: User = Depends(get_admin_user),
):
    """Admin: List pencairan"""
    query = {}
    if program_id:
        query["program_id"] = program_id

    items = await Withdrawal.find(query).sort("-created_at").to_list()
    return [{"id": str(w.id), **w.dict()} for w in items]


@router.put("/withdrawals/{withdrawal_id}/disburse")
async def disburse_withdrawal(
    request: Request,
    withdrawal_id: str,
    user: User = Depends(get_admin_user),
):
    """Admin: Tandai pencairan selesai (disburse)"""
    w = await Withdrawal.get(withdrawal_id)
    if not w:
        raise HTTPException(status_code=404, detail="Pencairan tidak ditemukan")

    w.status = "disbursed"
    w.updated_at = datetime.utcnow()
    await w.save()

    await log_audit(request, "withdrawal_disbursed", "withdrawal", str(w.id))

    return {"message": "Pencairan berhasil disalurkan"}


# ── Distribution Activities ──────────────

class DistributionCreate(BaseModel):
    withdrawal_id: str
    nama_kegiatan: str
    keterangan: Optional[str] = None
    bukti_file: Optional[str] = None


@router.post("/distributions")
async def create_distribution(
    request: Request,
    data: DistributionCreate,
    user: User = Depends(get_admin_user),
):
    """Admin: Buat kegiatan penyaluran"""
    dist = DistributionActivity(
        withdrawal_id=data.withdrawal_id,
        nama_kegiatan=data.nama_kegiatan,
        keterangan=data.keterangan,
        bukti_file=data.bukti_file,
    )
    await dist.insert()
    await log_audit(request, "distribution_created", "distribution", str(dist.id))
    return {"message": "Kegiatan penyaluran dibuat", "id": str(dist.id)}


# ── Audit Logs ───────────────────────────

@router.get("/audit-logs")
async def list_audit_logs(
    page: int = Query(1, ge=1),
    limit: int = Query(50, le=200),
    action: Optional[str] = None,
    user: User = Depends(get_admin_user),
):
    """Admin: Lihat audit logs"""
    query = {}
    if action:
        query["action"] = action

    items = AuditLog.find(query).sort("-created_at")
    total = await items.count()
    data = await items.skip((page - 1) * limit).limit(limit).to_list()

    return {
        "data": [{**a.dict(), "id": str(a.id)} for a in data],
        "total": total,
        "page": page,
    }


# ── Team, Partner, Bank management ───────

@router.get("/teams")
async def list_teams():
    """List team members (public)"""
    items = await Team.find_all().sort("urutan").to_list()
    return [{**t.dict(), "id": str(t.id)} for t in items]


@router.get("/partners")
async def list_partners():
    """List partners (public)"""
    items = await Partner.find_all().sort("urutan").to_list()
    return [{**p.dict(), "id": str(p.id)} for p in items]


@router.get("/banks")
async def list_banks():
    """List bank accounts (public)"""
    items = await Bank.find_all().to_list()
    return [{**b.dict(), "id": str(b.id)} for b in items]


@router.get("/export/donasi")
async def export_donasi(user: User = Depends(get_admin_user)):
    """Export donasi CSV"""
    items = await Donasi.find({"status": "berhasil"}).sort("-created_at").to_list()

    csv_lines = ["Nama,Email,Jumlah,Metode,Program,Tanggal"]
    for d in items:
        prog = await Program.get(d.program_id)
        csv_lines.append(
            f'"{d.nama or "Anonim"}","{d.email or ""}",{d.jumlah},"{d.metode_pembayaran}","{prog.nama if prog else "-"}",{d.created_at.isoformat()}'
        )

    return {"csv": "\n".join(csv_lines)}
