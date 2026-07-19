"""File Storage Service — Object Storage (S3-compatible)"""

import uuid
from typing import Optional
import httpx
import boto3
from botocore.config import Config
from app.config import settings


class StorageService:
    """Service untuk upload file ke Object Storage (DigitalOcean Spaces / S3)"""

    _client = None

    @classmethod
    def _get_client(cls):
        if cls._client is None and settings.STORAGE_ENDPOINT:
            cls._client = boto3.client(
                "s3",
                endpoint_url=settings.STORAGE_ENDPOINT,
                aws_access_key_id=settings.STORAGE_ACCESS_KEY,
                aws_secret_access_key=settings.STORAGE_SECRET_KEY,
                region_name=settings.STORAGE_REGION,
                config=Config(signature_version="s3v4"),
            )
        return cls._client

    @classmethod
    async def upload_file(
        cls,
        file_content: bytes,
        filename: str,
        folder: str = "uploads",
        content_type: str = "application/octet-stream",
    ) -> Optional[str]:
        """
        Upload file ke object storage.
        Returns CDN URL jika berhasil, None jika gagal.
        """
        client = cls._get_client()
        if client is None:
            # Fallback: simpan ke lokal (untuk development)
            return await cls._upload_local(file_content, filename, folder)

        ext = filename.rsplit(".", 1)[-1] if "." in filename else ""
        unique_name = f"{folder}/{uuid.uuid4().hex}.{ext}"

        try:
            client.put_object(
                Bucket=settings.STORAGE_BUCKET,
                Key=unique_name,
                Body=file_content,
                ContentType=content_type,
                ACL="public-read",
            )

            if settings.STORAGE_CDN_URL:
                return f"{settings.STORAGE_CDN_URL}/{unique_name}"
            return f"{settings.STORAGE_ENDPOINT}/{settings.STORAGE_BUCKET}/{unique_name}"
        except Exception as e:
            print(f"Storage upload error: {e}")
            return None

    @classmethod
    async def _upload_local(
        cls, file_content: bytes, filename: str, folder: str = "uploads"
    ) -> str:
        """Fallback: simpan ke folder lokal (development only)"""
        import os
        ext = filename.rsplit(".", 1)[-1] if "." in filename else ""
        unique_name = f"{uuid.uuid4().hex}.{ext}"
        local_path = f"uploads/{folder}"
        os.makedirs(local_path, exist_ok=True)

        filepath = f"{local_path}/{unique_name}"
        with open(filepath, "wb") as f:
            f.write(file_content)

        return f"/{filepath}"

    @classmethod
    def get_public_url(cls, key: str) -> str:
        """Get public URL for a stored file"""
        if key.startswith("http"):
            return key
        if key.startswith("/uploads/"):
            return key
        if settings.STORAGE_CDN_URL:
            return f"{settings.STORAGE_CDN_URL}/{key}"
        return key
