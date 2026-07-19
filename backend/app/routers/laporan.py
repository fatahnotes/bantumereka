"""Laporan Bantuan Router — kirim data + moderasi"""

from typing import Optional
from fastapi import APIRouter, Request, UploadFile, File, Form, Depends, HTTPException, Query
from datetime import datetime

from app.models.laporan import LaporanBantuan
from app.models.user import User
from app.utils.auth import get_admin_user
from app.services.storage import StorageService
from app.services.recaptcha import verify_recaptcha
from app.middleware.rate_limit import limiter
from app.middleware.audit import log_audit

router = APIRouter(prefix="/api/laporan", tags=["Laporan"])


# ── Public endpoint ──────────────────────

@router.post("/kirim")
@limiter.limit("5/minute")
async def kirim_laporan(
    request: Request,
    nama_pelapor: str = Form(...),
    kontak_pelapor: Optional[str] = Form(None),
    ketua_rt: Optional[str] = Form(None),
    kontak_rt: Optional[str] = Form(None),
    nama_sasaran: Optional[str] = Form(None),
    provinsi: str = Form(...),
    kabupaten: str = Form(...),
    kecamatan: str = Form(...),
    kelurahan: Optional[str] = Form(None),
    kelurahan_manual: Optional[str] = Form(None),
    alamat_detail: Optional[str] = Form(None),
    kategori_id: Optional[str] = Form(None),
    permasalahan: Optional[str] = Form(None),
    link_pendukung: Optional[str] = Form(None),
    tingkat_urgensi: int = Form(5),
    file_proposal: Optional[UploadFile] = File(None),
    file_pendukung: Optional[UploadFile] = File(None),
    recaptcha_token: Optional[str] = Form(None),
):
    """Kirim data penerima manfaat / laporan bantuan"""

    # Verify reCAPTCHA
    if recaptcha_token:
        if not await verify_recaptcha(recaptcha_token):
            raise HTTPException(status_code=400, detail="Verifikasi reCAPTCHA gagal")

    # Validate tingkat_urgensi
    if tingkat_urgensi < 1 or tingkat_urgensi > 10:
        tingkat_urgensi = 5

    final_kelurahan = kelurahan if kelurahan and kelurahan != "" else kelurahan_manual

    # Upload proposal (PDF, max 2MB)
    proposal_url = None
    if file_proposal and file_proposal.filename:
        content = await file_proposal.read()
        if len(content) > 2 * 1024 * 1024:
            raise HTTPException(status_code=400, detail="File proposal maksimal 2MB")
        proposal_url = await StorageService.upload_file(
            content, file_proposal.filename, "laporan/proposal", "application/pdf"
        )

    # Upload pendukung (PDF, max 2MB)
    pendukung_url = None
    if file_pendukung and file_pendukung.filename:
        content = await file_pendukung.read()
        if len(content) > 2 * 1024 * 1024:
            raise HTTPException(status_code=400, detail="File pendukung maksimal 2MB")
        pendukung_url = await StorageService.upload_file(
            content, file_pendukung.filename, "laporan/pendukung", "application/pdf"
        )

    laporan = LaporanBantuan(
        nama_pelapor=nama_pelapor,
        kontak_pelapor=kontak_pelapor,
        ketua_rt=ketua_rt,
        kontak_rt=kontak_rt,
        nama_sasaran=nama_sasaran,
        provinsi=provinsi,
        kabupaten=kabupaten,
        kecamatan=kecamatan,
        kelurahan=final_kelurahan,
        alamat_detail=alamat_detail,
        kategori_id=kategori_id,
        permasalahan=permasalahan,
        link_pendukung=link_pendukung,
        tingkat_urgensi=tingkat_urgensi,
        file_proposal=proposal_url,
        file_pendukung=pendukung_url,
    )
    await laporan.insert()

    await log_audit(request, "laporan_created", "laporan_bantuan", str(laporan.id))

    return {
        "message": "Laporan berhasil dikirim! Tim kami akan meninjau data Anda.",
        "id": str(laporan.id),
    }


# ── Admin endpoints ──────────────────────

@router.get("")
async def list_laporan(
    page: int = Query(1, ge=1),
    limit: int = Query(20, ge=1, le=100),
    admin_status: Optional[str] = None,
    kategori_id: Optional[str] = None,
    user: User = Depends(get_admin_user),
):
    """Admin: List laporan bantuan"""
    query = {}
    if admin_status:
        query["admin_status"] = admin_status
    if kategori_id:
        query["kategori_id"] = kategori_id

    laporan_list = LaporanBantuan.find(query).sort("-created_at")
    total = await laporan_list.count()
    items = await laporan_list.skip((page - 1) * limit).limit(limit).to_list()

    return {
        "data": [{**l.dict(), "id": str(l.id)} for l in items],
        "total": total,
        "page": page,
    }


@router.get("/{laporan_id}")
async def get_laporan_detail(laporan_id: str, user: User = Depends(get_admin_user)):
    """Admin: Detail laporan"""
    laporan = await LaporanBantuan.get(laporan_id)
    if not laporan:
        raise HTTPException(status_code=404, detail="Laporan tidak ditemukan")

    return {**laporan.dict(), "id": str(laporan.id)}


@router.put("/{laporan_id}/status")
async def update_laporan_status(
    laporan_id: str,
    admin_status: str = Form(...),
    admin_urgensi: Optional[int] = Form(None),
    admin_keterangan: Optional[str] = Form(None),
    admin_prioritas: bool = Form(False),
    user: User = Depends(get_admin_user),
):
    """Admin: Update status & moderasi laporan"""
    laporan = await LaporanBantuan.get(laporan_id)
    if not laporan:
        raise HTTPException(status_code=404, detail="Laporan tidak ditemukan")

    laporan.admin_status = admin_status
    if admin_urgensi is not None:
        laporan.admin_urgensi = admin_urgensi
    if admin_keterangan:
        laporan.admin_keterangan = admin_keterangan
    laporan.admin_prioritas = admin_prioritas
    laporan.updated_at = datetime.utcnow()
    await laporan.save()

    return {"message": "Status laporan berhasil diupdate"}
