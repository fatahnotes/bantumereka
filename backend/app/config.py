"""
Bantu Mereka — Application Configuration
Loads from .env file and environment variables
"""

from pydantic_settings import BaseSettings
from typing import List
import os


class Settings(BaseSettings):
    # ── App ────────────────────────────
    APP_NAME: str = "Bantu Mereka API"
    APP_VERSION: str = "1.0.0"
    DEBUG: bool = True
    ENVIRONMENT: str = "development"

    # ── Server ─────────────────────────
    HOST: str = "0.0.0.0"
    PORT: int = 8000

    # ── MongoDB ────────────────────────
    MONGODB_URL: str = "mongodb://localhost:27017"
    MONGODB_DB_NAME: str = "bantumereka"

    # ── JWT ────────────────────────────
    JWT_SECRET_KEY: str = "change-me-in-production"
    JWT_ALGORITHM: str = "HS256"
    JWT_EXPIRE_MINUTES: int = 1440  # 24 hours

    # ── Midtrans ───────────────────────
    MIDTRANS_SERVER_KEY: str = ""
    MIDTRANS_CLIENT_KEY: str = ""
    MIDTRANS_IS_PRODUCTION: bool = False
    MIDTRANS_MERCHANT_ID: str = ""

    # ── Email (Resend) ─────────────────
    RESEND_API_KEY: str = ""
    EMAIL_FROM: str = "noreply@bantumereka.org"
    EMAIL_FROM_NAME: str = "Bantu Mereka"

    # ── reCAPTCHA ──────────────────────
    RECAPTCHA_SITE_KEY: str = ""
    RECAPTCHA_SECRET_KEY: str = ""

    # ── Object Storage ─────────────────
    STORAGE_ENDPOINT: str = ""
    STORAGE_ACCESS_KEY: str = ""
    STORAGE_SECRET_KEY: str = ""
    STORAGE_BUCKET: str = "bantumereka-uploads"
    STORAGE_REGION: str = "sgp1"
    STORAGE_CDN_URL: str = ""

    # ── Sentry ─────────────────────────
    SENTRY_DSN: str = ""

    # ── CORS ───────────────────────────
    CORS_ORIGINS: str = "http://localhost:5173,http://localhost:3000"

    # ── Frontend ───────────────────────
    FRONTEND_URL: str = "http://localhost:5173"

    @property
    def cors_origins_list(self) -> List[str]:
        return [o.strip() for o in self.CORS_ORIGINS.split(",") if o.strip()]

    @property
    def midtrans_api_url(self) -> str:
        if self.MIDTRANS_IS_PRODUCTION:
            return "https://app.midtrans.com/snap/v1/transactions"
        return "https://app.sandbox.midtrans.com/snap/v1/transactions"

    model_config = {
        "env_file": ".env",
        "env_file_encoding": "utf-8",
    }


settings = Settings()
