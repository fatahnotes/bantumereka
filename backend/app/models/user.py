"""User model — admin & moderator"""

from typing import Optional
from datetime import datetime
from beanie import Document
from pydantic import Field
from enum import Enum


class UserRole(str, Enum):
    SUPERADMIN = "superadmin"
    ADMIN = "admin"
    MODERATOR = "moderator"


class User(Document):
    """Admin / Moderator user"""
    username: str
    password_hash: str
    nama: Optional[str] = None
    email: Optional[str] = None
    role: str = "admin"
    is_active: bool = True
    last_login: Optional[datetime] = None
    created_at: datetime = Field(default_factory=datetime.utcnow)
    updated_at: Optional[datetime] = None

    class Settings:
        name = "user"
