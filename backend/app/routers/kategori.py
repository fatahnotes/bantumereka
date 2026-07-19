"""Kategori Router — CRUD Kategori"""

from typing import Optional
from fastapi import APIRouter, Depends, HTTPException, Query
from pydantic import BaseModel
from slugify import slugify

from app.models.kategori import Kategori
from app.models.user import User
from app.utils.auth import get_admin_user

router = APIRouter(prefix="/api/kategori", tags=["Kategori"])


class KategoriCreate(BaseModel):
    nama: str


class KategoriUpdate(BaseModel):
    nama: str | None = None


@router.get("")
async def list_kategori():
    """List semua kategori (public)"""
    items = await Kategori.find_all().sort("nama").to_list()
    return [{"id": str(k.id), "nama": k.nama, "slug": k.slug} for k in items]


@router.post("")
async def create_kategori(data: KategoriCreate, user: User = Depends(get_admin_user)):
    """Admin: Buat kategori baru"""
    slug = slugify(data.nama)

    existing = await Kategori.find_one({"slug": slug})
    if existing:
        raise HTTPException(status_code=400, detail="Kategori sudah ada")

    kat = Kategori(nama=data.nama, slug=slug)
    await kat.insert()

    return {"message": "Kategori berhasil dibuat", "id": str(kat.id)}


@router.put("/{kategori_id}")
async def update_kategori(
    kategori_id: str,
    data: KategoriUpdate,
    user: User = Depends(get_admin_user),
):
    """Admin: Update kategori"""
    kat = await Kategori.get(kategori_id)
    if not kat:
        raise HTTPException(status_code=404, detail="Kategori tidak ditemukan")

    if data.nama:
        kat.nama = data.nama
        kat.slug = slugify(data.nama)
    await kat.save()

    return {"message": "Kategori berhasil diupdate"}


@router.delete("/{kategori_id}")
async def delete_kategori(kategori_id: str, user: User = Depends(get_admin_user)):
    """Admin: Hapus kategori"""
    kat = await Kategori.get(kategori_id)
    if not kat:
        raise HTTPException(status_code=404, detail="Kategori tidak ditemukan")

    await kat.delete()
    return {"message": "Kategori berhasil dihapus"}
