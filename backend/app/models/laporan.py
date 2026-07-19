"""Laporan Bantuan model — kirim data penerima manfaat"""

from typing import Optional
from datetime import datetime
from beanie import Document
from pydantic import Field


class LaporanBantuan(Document):
    """Laporan/data calon penerima manfaat"""
    nama_pelapor: str
    kontak_pelapor: Optional[str] = None
    ketua_rt: Optional[str] = None
    kontak_rt: Optional[str] = None
    nama_sasaran: Optional[str] = None

    # Alamat
    provinsi: str
    kabupaten: str
    kecamatan: str
    kelurahan: Optional[str] = None
    alamat_detail: Optional[str] = None

    # Kategori & detail
    kategori_id: Optional[str] = None
    permasalahan: Optional[str] = None
    link_pendukung: Optional[str] = None
    tingkat_urgensi: int = 5  # 1-10

    # File upload
    file_proposal: Optional[str] = None  # URL
    file_pendukung: Optional[str] = None  # URL

    # Moderasi admin
    admin_urgensi: Optional[int] = None
    admin_keterangan: Optional[str] = None
    admin_prioritas: bool = False
    admin_status: str = "baru"  # baru, verifikasi, approve, pending, tolak

    # Status
    status: str = "baru"  # baru, diproses, selesai

    created_at: datetime = Field(default_factory=datetime.utcnow)
    updated_at: Optional[datetime] = None

    class Settings:
        name = "laporan_bantuan"
