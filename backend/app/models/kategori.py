"""Kategori model — untuk kategori program donasi"""

from typing import Optional
from datetime import datetime
from beanie import Document
from pydantic import Field


class Kategori(Document):
    """Kategori program: Pangan, Pendidikan, Kesehatan, dll."""
    nama: str
    slug: Optional[str] = None
    created_at: datetime = Field(default_factory=datetime.utcnow)

    class Settings:
        name = "kategori"
