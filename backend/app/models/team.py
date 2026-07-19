"""Team model, Partner model, Bank model, Withdrawal model"""

from typing import Optional
from datetime import datetime
from beanie import Document
from pydantic import Field


class Team(Document):
    """Anggota tim — ditampilkan di halaman About"""
    nama: str
    jabatan: str
    bio: Optional[str] = None
    foto: Optional[str] = None
    urutan: int = 0
    created_at: datetime = Field(default_factory=datetime.utcnow)

    class Settings:
        name = "team"


class Partner(Document):
    """Partner / pendukung"""
    nama: str
    logo: Optional[str] = None
    website_url: Optional[str] = None
    urutan: int = 0
    created_at: datetime = Field(default_factory=datetime.utcnow)

    class Settings:
        name = "partners"


class Bank(Document):
    """Rekening bank untuk donasi"""
    nama_bank: str
    no_rekening: str
    atas_nama: str
    gambar_qris: Optional[str] = None
    is_active: bool = True

    class Settings:
        name = "bank"


class WhatsappGroup(Document):
    """Link WhatsApp Group per provinsi untuk relawan"""
    provinsi: str
    link_whatsapp: str
    created_at: datetime = Field(default_factory=datetime.utcnow)

    class Settings:
        name = "whatsapp_grup"
