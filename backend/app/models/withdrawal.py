"""Withdrawal & Distribution models — pencairan & penyaluran dana"""

from typing import Optional, List
from datetime import datetime
from beanie import Document
from pydantic import Field


class DistributionRecipient(Document):
    """Penerima manfaat per kegiatan penyaluran"""
    activity_id: str
    nama: str
    jumlah_diterima: float
    kontak: Optional[str] = None
    alamat: Optional[str] = None
    keterangan: Optional[str] = None
    created_at: datetime = Field(default_factory=datetime.utcnow)

    class Settings:
        name = "distribution_recipients"


class DistributionActivity(Document):
    """Kegiatan penyaluran dana"""
    withdrawal_id: str
    nama_kegiatan: str
    keterangan: Optional[str] = None
    kategori_dist_id: Optional[str] = None
    bukti_file: Optional[str] = None  # URL foto/bukti
    recipients: List[str] = []  # List of DistributionRecipient IDs
    total_disalurkan: float = 0
    created_at: datetime = Field(default_factory=datetime.utcnow)

    class Settings:
        name = "distribution_activities"


class Withdrawal(Document):
    """Pencairan dana program"""
    program_id: str
    jumlah: float
    milestone_id: Optional[str] = None
    status: str = "pending"  # pending, approved, disbursed, rejected
    keterangan: Optional[str] = None
    approved_by: Optional[str] = None
    approved_at: Optional[datetime] = None

    # Hash untuk public ledger
    ledger_hash: Optional[str] = None
    ledger_prev_hash: Optional[str] = None

    created_at: datetime = Field(default_factory=datetime.utcnow)
    updated_at: Optional[datetime] = None

    class Settings:
        name = "withdrawals"
