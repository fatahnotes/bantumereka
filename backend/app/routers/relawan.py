"""Relawan Router — pendaftaran relawan + moderasi admin"""

from typing import Optional, List
from fastapi import APIRouter, Request, UploadFile, File, Form, Depends, HTTPException, Query
from datetime import datetime

from app.models.relawan import Relawan
from app.models.team import WhatsappGroup
from app.models.user import User
from app.utils.auth import get_admin_user
from app.services.storage import StorageService
from app.services.recaptcha import verify_recaptcha
from app.middleware.rate_limit import limiter
from app.middleware.audit import log_audit

router = APIRouter(prefix="/api/relawan", tags=["Relawan"])


# ── Public endpoint ──────────────────────

@router.post("/register")
@limiter.limit("5/minute")
async def register_relawan(
    request: Request,
    nama_lengkap: str = Form(...),
    email: str = Form(...),
    no_hp: str = Form(...),
    bulan_tahun_lahir: Optional[str] = Form(None),
    jenis_kelamin: Optional[str] = Form(None),
    kontak_darurat: Optional[str] = Form(None),
    provinsi: str = Form(...),
    kabupaten: str = Form(...),
    kecamatan: str = Form(...),
    kelurahan: Optional[str] = Form(None),
    kelurahan_manual: Optional[str] = Form(None),
    alamat_detail: Optional[str] = Form(None),
    motivasi: str = Form(...),
    pengalaman_relawan: Optional[str] = Form(None),
    riwayat_pekerjaan: Optional[str] = Form(None),
    keahlian: Optional[str] = Form(None),
    riwayat_kesehatan: Optional[str] = Form(None),
    hobi: Optional[str] = Form(None),
    organisasi: Optional[str] = Form(None),
    pendidikan_terakhir: Optional[str] = Form(None),
    prodi: Optional[str] = Form(None),
    pernyataan: bool = Form(False),
    foto: Optional[UploadFile] = File(None),
    sosial_jenis: List[str] = Form([]),
    sosial_url: List[str] = Form([]),
    recaptcha_token: Optional[str] = Form(None),
):
    """Pendaftaran relawan baru"""

    # Verify reCAPTCHA
    if recaptcha_token:
        if not await verify_recaptcha(recaptcha_token):
            raise HTTPException(status_code=400, detail="Verifikasi reCAPTCHA gagal")

    # Check duplicate email
    existing = await Relawan.find_one({"email": email})
    if existing:
        raise HTTPException(status_code=400, detail="Email sudah terdaftar")

    # Use manual kelurahan if dropdown not selected
    final_kelurahan = kelurahan if kelurahan and kelurahan != "" else kelurahan_manual

    # Upload foto
    foto_url = None
    if foto and foto.filename:
        content = await foto.read()
        foto_url = await StorageService.upload_file(
            content, foto.filename, "relawan", foto.content_type or "image/jpeg"
        )

    # Build sosial media list
    sosial_list = []
    for i, jenis in enumerate(sosial_jenis):
        if jenis and i < len(sosial_url) and sosial_url[i]:
            sosial_list.append({"jenis": jenis, "url": sosial_url[i]})

    # Create relawan
    relawan = Relawan(
        nama_lengkap=nama_lengkap,
        email=email,
        no_hp=no_hp,
        bulan_tahun_lahir=bulan_tahun_lahir,
        jenis_kelamin=jenis_kelamin,
        kontak_darurat=kontak_darurat,
        provinsi=provinsi,
        kabupaten=kabupaten,
        kecamatan=kecamatan,
        kelurahan=final_kelurahan,
        alamat_detail=alamat_detail,
        motivasi=motivasi,
        pengalaman_relawan=pengalaman_relawan,
        riwayat_pekerjaan=riwayat_pekerjaan,
        keahlian=keahlian,
        riwayat_kesehatan=riwayat_kesehatan,
        hobi=hobi,
        organisasi=organisasi,
        pendidikan_terakhir=pendidikan_terakhir,
        prodi=prodi,
        pernyataan=pernyataan,
        foto=foto_url,
        sosial_media=sosial_list,
    )
    await relawan.insert()

    # Get WA Group link for provinsi
    wa_group = await WhatsappGroup.find_one({"provinsi": provinsi})
    wa_link = wa_group.link_whatsapp if wa_group else None

    await log_audit(request, "relawan_registered", "relawan", str(relawan.id))

    return {
        "message": "Pendaftaran berhasil! Data Anda sedang diverifikasi.",
        "id": str(relawan.id),
        "wa_group_link": wa_link,
    }


# ── Admin endpoints ──────────────────────

@router.get("")
async def list_relawan(
    page: int = Query(1, ge=1),
    limit: int = Query(20, ge=1, le=100),
    admin_status: Optional[str] = None,
    provinsi: Optional[str] = None,
    user: User = Depends(get_admin_user),
):
    """Admin: List relawan"""
    query = {}
    if admin_status:
        query["admin_status"] = admin_status
    if provinsi:
        query["provinsi"] = provinsi

    relawan_list = Relawan.find(query).sort("-created_at")
    total = await relawan_list.count()
    items = await relawan_list.skip((page - 1) * limit).limit(limit).to_list()

    return {
        "data": [{**r.dict(), "id": str(r.id)} for r in items],
        "total": total,
        "page": page,
    }


@router.get("/{relawan_id}")
async def get_relawan_detail(relawan_id: str, user: User = Depends(get_admin_user)):
    """Admin: Detail relawan"""
    relawan = await Relawan.get(relawan_id)
    if not relawan:
        raise HTTPException(status_code=404, detail="Relawan tidak ditemukan")

    return {**relawan.dict(), "id": str(relawan.id)}


@router.put("/{relawan_id}/status")
async def update_relawan_status(
    relawan_id: str,
    admin_status: str = Form(...),
    admin_keterangan: Optional[str] = Form(None),
    user: User = Depends(get_admin_user),
):
    """Admin: Update status verifikasi relawan"""
    relawan = await Relawan.get(relawan_id)
    if not relawan:
        raise HTTPException(status_code=404, detail="Relawan tidak ditemukan")

    relawan.admin_status = admin_status
    if admin_keterangan:
        relawan.admin_keterangan = admin_keterangan
    if admin_status == "approve":
        relawan.admin_verified_at = datetime.utcnow()
    relawan.updated_at = datetime.utcnow()
    await relawan.save()

    return {"message": "Status relawan berhasil diupdate"}
