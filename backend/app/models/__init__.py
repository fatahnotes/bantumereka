"""Base Beanie Document with common fields"""

from datetime import datetime
from typing import Optional
from beanie import Document


class BaseDocument(Document):
    """Base document with common fields"""
    created_at: datetime = datetime.utcnow()
    updated_at: Optional[datetime] = None

    class Settings:
        use_state_management = True
