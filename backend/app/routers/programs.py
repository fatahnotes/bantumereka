"""Programs Router — CRUD program + publik listing"""

from typing import Optional
from fastapi import APIRouter, Depends, HTTPException, Query, status
from pydantic import BaseModel
from slugify import slugify
from datetime import datetime

from app.models.program import Program
from app.models.kategori import Kategori
from app.models.donasi import Donasi
from app.utils.auth import get_current_user, get_admin_user
from app.models.user import User

router = APIRouter(prefix="/api/programs", tags=["Programs"])


class ProgramCreate(BaseModel):
    nama: str
    deskripsi: str = ""
    deskripsi_lengkap: str = ""
    target_donasi: float = 0
    gambar: str | None = None
    kategori_id: str | None = None
    is_active: bool = True
    is_prioritas: bool = False
    is_urgent: bool = False
    provinsi: str | None = None
    kabupaten: str | None = None
    lokasi: str | None = None
    penggalang_nama: str | None = None
    penggalang_kontak: str | None = None
    tanggal_selesai: datetime | None = None


class ProgramUpdate(BaseModel):
    nama: str | None = None
    deskripsi: str | None = None
    deskripsi_lengkap: str | None = None
    target_donasi: float | None = None
    gambar: str | None = None
    kategori_id: str | None = None
    is_active: bool | None = None
    is_prioritas: bool | None = None
    is_urgent: bool | None = None
    is_verified: bool | None = None
    provinsi: str | None = None
    kabupaten: str | None = None
    lokasi: str | None = None


# ── Public endpoints ──────────────────────

@router.get("")
async def list_programs(
    page: int = Query(1, ge=1),
    limit: int = Query(12, ge=1, le=50),
    kategori_id: Optional[str] = None,
    is_prioritas: Optional[bool] = None,
    search: Optional[str] = None,
):
    """List program publik dengan filter"""
    query = {"is_active": True}

    if kategori_id:
        query["kategori_id"] = kategori_id
    if is_prioritas is not None:
        query["is_prioritas"] = is_prioritas

    programs = Program.find(query)

    if search:
        programs = programs.find({"$text": {"$search": search}})

    total = await programs.count()
    items = (
        await programs.sort("-created_at")
        .skip((page - 1) * limit)
        .limit(limit)
        .to_list()
    )

    # Enrich with kategori name
    result = []
    for p in items:
        p_dict = p.dict()
        p_dict["id"] = str(p.id)
        if p.kategori_id:
            kat = await Kategori.get(p.kategori_id)
            p_dict["kategori_nama"] = kat.nama if kat else None
        else:
            p_dict["kategori_nama"] = None
        result.append(p_dict)

    return {
        "data": result,
        "total": total,
        "page": page,
        "total_pages": max(1, (total + limit - 1) // limit),
    }


@router.get("/prioritas")
async def list_prioritas():
    """List program prioritas (untuk slider)"""
    programs = (
        await Program.find({"is_active": True, "is_prioritas": True})
        .sort("-created_at")
        .to_list()
    )
    result = []
    for p in programs:
        d = p.dict()
        d["id"] = str(p.id)
        if p.kategori_id:
            kat = await Kategori.get(p.kategori_id)
            d["kategori_nama"] = kat.nama if kat else None
        else:
            d["kategori_nama"] = None
        result.append(d)
    return result


@router.get("/terbaru")
async def list_terbaru(limit: int = Query(8, le=20)):
    """List program terbaru"""
    programs = (
        await Program.find({"is_active": True})
        .sort("-created_at")
        .limit(limit)
        .to_list()
    )
    result = []
    for p in programs:
        d = p.dict()
        d["id"] = str(p.id)
        if p.kategori_id:
            kat = await Kategori.get(p.kategori_id)
            d["kategori_nama"] = kat.nama if kat else None
        else:
            d["kategori_nama"] = None
        result.append(d)
    return result


@router.get("/stats")
async def get_stats():
    """Statistik dampak untuk homepage"""
    total_program_aktif = await Program.find({"is_active": True}).count()
    total_penerima = await Program.aggregate([
        {"$group": {"_id": None, "total": {"$sum": "$jumlah_donatur"}}}
    ]).to_list()
    total_donatur = await Donasi.aggregate([
        {"$match": {"status": "berhasil"}},
        {"$group": {"_id": "$email", "count": {"$sum": 1}}}
    ]).to_list()

    return {
        "total_program_aktif": total_program_aktif,
        "total_penerima": total_penerima[0]["total"] if total_penerima else 0,
        "total_donatur_unik": len(total_donatur),
    }


@router.get("/{program_id}")
async def get_program(program_id: str):
    """Detail program"""
    program = await Program.get(program_id)
    if not program:
        raise HTTPException(status_code=404, detail="Program tidak ditemukan")

    # Get donatur list
    donatur_list = (
        await Donasi.find(
            {"program_id": program_id, "status": "berhasil"}
        )
        .sort("-created_at")
        .limit(50)
        .to_list()
    )

    result = serialize_program(program)
    result["donatur"] = [
        {
            "nama": "Anonim" if d.is_anonim else (d.nama or "Anonim"),
            "jumlah": d.jumlah,
            "tanggal": d.created_at.isoformat(),
        }
        for d in donatur_list
    ]

    return result


@router.get("/{program_id}/ledger")
async def get_program_ledger(program_id: str):
    """Public ledger untuk transparansi dana"""
    donations = (
        await Donasi.find({"program_id": program_id, "status": "berhasil"})
        .sort("+created_at")
        .to_list()
    )
    from app.models.withdrawal import Withdrawal
    withdrawals = (
        await Withdrawal.find({"program_id": program_id, "status": "disbursed"})
        .sort("+created_at")
        .to_list()
    )

    ledger = []
    for d in donations:
        ledger.append({
            "type": "donasi",
            "id": str(d.id),
            "tanggal": d.created_at.isoformat(),
            "jumlah": d.jumlah,
            "nama": "Anonim" if d.is_anonim else (d.nama or "Anonim"),
            "hash": d.ledger_hash,
            "prev_hash": d.ledger_prev_hash,
        })
    for w in withdrawals:
        ledger.append({
            "type": "penyaluran",
            "id": str(w.id),
            "tanggal": w.created_at.isoformat(),
            "jumlah": w.jumlah,
            "keterangan": w.keterangan,
            "hash": w.ledger_hash,
            "prev_hash": w.ledger_prev_hash,
        })

    return {"program_id": program_id, "records": ledger}


# ── Admin endpoints ──────────────────────

@router.post("")
async def create_program(data: ProgramCreate, user: User = Depends(get_admin_user)):
    """Admin: Buat program baru"""
    program = Program(
        **data.dict(),
        slug=slugify(data.nama),
    )
    await program.insert()
    return {"message": "Program berhasil dibuat", "id": str(program.id)}


@router.put("/{program_id}")
async def update_program(
    program_id: str,
    data: ProgramUpdate,
    user: User = Depends(get_admin_user),
):
    """Admin: Update program"""
    program = await Program.get(program_id)
    if not program:
        raise HTTPException(status_code=404, detail="Program tidak ditemukan")

    update_data = {k: v for k, v in data.dict().items() if v is not None}
    if "nama" in update_data:
        update_data["slug"] = slugify(update_data["nama"])

    await program.update({"$set": update_data})
    return {"message": "Program berhasil diupdate"}


@router.delete("/{program_id}")
async def delete_program(program_id: str, user: User = Depends(get_admin_user)):
    """Admin: Hapus program"""
    program = await Program.get(program_id)
    if not program:
        raise HTTPException(status_code=404, detail="Program tidak ditemukan")

    await program.delete()
    return {"message": "Program berhasil dihapus"}


# ── Helpers ──────────────────────────────

async def serialize_program(p: Program) -> dict:
    """Serialize program with computed fields"""
    d = p.dict()
    d["id"] = str(p.id)

    # Get kategori name
    if p.kategori_id:
        kat = await Kategori.get(p.kategori_id)
        d["kategori_nama"] = kat.nama if kat else None
    else:
        d["kategori_nama"] = None

    # Progress percentage
    if p.target_donasi > 0:
        d["progress_persen"] = min(100, round((p.total_terkumpul / p.target_donasi) * 100))
    else:
        d["progress_persen"] = 0

    return d
