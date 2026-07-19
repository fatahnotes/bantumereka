"""Program model — program donasi / penggalangan dana"""

from typing import Optional, List
from datetime import datetime
from beanie import Document
from pydantic import Field
from bson import ObjectId
from pydantic import field_validator


class ProgramMilestone(Document):
    """Milestone pencairan dana per program"""
    program_id: str
    nama: str
    deskripsi: str
    persentase: float  # % dari total dana
    jumlah: float
    status: str = "pending"  # pending, approved, disbursed
    bukti_file: Optional[str] = None
    approved_by: Optional[str] = None
    approved_at: Optional[datetime] = None
    created_at: datetime = Field(default_factory=datetime.utcnow)

    class Settings:
        name = "program_milestones"


class Program(Document):
    """Program penggalangan dana"""
    nama: str
    slug: Optional[str] = None
    deskripsi: str = ""
    deskripsi_lengkap: str = ""
    target_donasi: float = 0
    gambar: Optional[str] = None  # URL gambar
    kategori_id: Optional[str] = None
    is_active: bool = True
    is_prioritas: bool = False
    is_urgent: bool = False
    is_verified: bool = False

    # KYC — penggalang program
    penggalang_nama: Optional[str] = None
    penggalang_kontak: Optional[str] = None
    penggalang_identitas: Optional[str] = None  # URL file KTP/SIM

    # Tanggal program
    tanggal_mulai: Optional[datetime] = None
    tanggal_selesai: Optional[datetime] = None

    # Transparansi
    total_terkumpul: float = 0
    total_disalurkan: float = 0
    jumlah_donatur: int = 0

    # Meta
    provinsi: Optional[str] = None
    kabupaten: Optional[str] = None
    lokasi: Optional[str] = None

    created_at: datetime = Field(default_factory=datetime.utcnow)
    updated_at: Optional[datetime] = None

    class Settings:
        name = "program"

    @field_validator("kategori_id", mode="before")
    @classmethod
    def convert_objectid(cls, v):
        if isinstance(v, ObjectId):
            return str(v)
        return v
