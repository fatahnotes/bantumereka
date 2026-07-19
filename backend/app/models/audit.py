"""Audit Log model — mencatat semua aksi penting"""

from typing import Optional
from datetime import datetime
from beanie import Document
from pydantic import Field


class AuditLog(Document):
    """Catatan audit untuk semua transaksi & aksi admin"""
    action: str  # e.g., "donasi_created", "program_approved", "withdrawal_disbursed"
    entity_type: str  # e.g., "donasi", "program", "withdrawal"
    entity_id: Optional[str] = None
    user_id: Optional[str] = None
    user_name: Optional[str] = None
    ip_address: Optional[str] = None
    user_agent: Optional[str] = None
    detail: Optional[dict] = None
    created_at: datetime = Field(default_factory=datetime.utcnow)

    class Settings:
        name = "audit_log"
