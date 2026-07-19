"""Relawan model — pendaftaran relawan"""

from typing import Optional, List
from datetime import datetime
from beanie import Document
from pydantic import Field


class RelawanSosial(Document):
    """Media sosial relawan"""
    relawan_id: str
    jenis: str  # instagram, facebook, twitter, tiktok, linkedin
    url: str

    class Settings:
        name = "relawan_sosial"


class Relawan(Document):
    """Data relawan terdaftar"""
    nama_lengkap: str
    email: str
    no_hp: str
    bulan_tahun_lahir: Optional[str] = None
    jenis_kelamin: Optional[str] = None
    kontak_darurat: Optional[str] = None

    # Alamat berjenjang
    provinsi: str
    kabupaten: str
    kecamatan: str
    kelurahan: Optional[str] = None
    alamat_detail: Optional[str] = None

    # Data relawan
    motivasi: str
    pengalaman_relawan: Optional[str] = None
    riwayat_pekerjaan: Optional[str] = None
    keahlian: Optional[str] = None
    riwayat_kesehatan: Optional[str] = None
    hobi: Optional[str] = None
    organisasi: Optional[str] = None
    pendidikan_terakhir: Optional[str] = None
    prodi: Optional[str] = None
    pernyataan: bool = False

    # Upload
    foto: Optional[str] = None  # URL foto

    # Media sosial
    sosial_media: List[dict] = []

    # Moderasi admin
    admin_status: str = "baru"  # baru, verifikasi, approve, tolak
    admin_keterangan: Optional[str] = None
    admin_verified_at: Optional[datetime] = None

    # WA Group
    wa_group_link: Optional[str] = None

    created_at: datetime = Field(default_factory=datetime.utcnow)
    updated_at: Optional[datetime] = None

    class Settings:
        name = "relawan"
