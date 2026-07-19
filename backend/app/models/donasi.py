"""Donasi model — catatan donasi"""

from typing import Optional
from datetime import datetime
from beanie import Document
from pydantic import Field
from enum import Enum


class DonasiStatus(str, Enum):
    PENDING = "pending"
    BERHASIL = "berhasil"
    GAGAL = "gagal"


class MetodePembayaran(str, Enum):
    TRANSFER = "transfer"
    QRIS = "qris"


class Donasi(Document):
    """Catatan donasi masuk"""
    program_id: str
    nama: Optional[str] = None
    email: Optional[str] = None
    no_hp: Optional[str] = None
    kecamatan: Optional[str] = None
    kabupaten: Optional[str] = None
    provinsi: Optional[str] = None
    jumlah: float
    metode_pembayaran: str = "transfer"
    bank_tujuan: Optional[str] = None
    status: str = "pending"
    is_anonim: bool = False

    # Midtrans
    midtrans_order_id: Optional[str] = None
    midtrans_token: Optional[str] = None
    midtrans_transaction_id: Optional[str] = None
    midtrans_payment_type: Optional[str] = None
    midtrans_va_number: Optional[str] = None
    midtrans_redirect_url: Optional[str] = None

    # Tax receipt
    tax_receipt_sent: bool = False
    tax_receipt_url: Optional[str] = None

    # Hash for public ledger
    ledger_hash: Optional[str] = None
    ledger_prev_hash: Optional[str] = None

    created_at: datetime = Field(default_factory=datetime.utcnow)
    updated_at: Optional[datetime] = None

    class Settings:
        name = "donasi"
