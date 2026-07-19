"""
Bantu Mereka — FastAPI Application Entry Point
===============================================
Platform donasi transparan dan akuntabel.
"""

from contextlib import asynccontextmanager
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from fastapi.staticfiles import StaticFiles
import logging

from app.config import settings
from app.database import init_db, close_db
from app.middleware.rate_limit import setup_rate_limit

# Routers
from app.routers import auth, programs, donations, relawan, laporan, kategori, admin

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)


@asynccontextmanager
async def lifespan(app: FastAPI):
    """Application lifespan: startup & shutdown events"""
    logger.info(f"🚀 Starting {settings.APP_NAME} v{settings.APP_VERSION}")

    # Setup Sentry if configured
    if settings.SENTRY_DSN:
        import sentry_sdk
        sentry_sdk.init(
            dsn=settings.SENTRY_DSN,
            environment=settings.ENVIRONMENT,
            traces_sample_rate=0.1,
        )
        logger.info("📊 Sentry initialized")

    # Initialize database
    await init_db()

    yield

    # Shutdown
    await close_db()
    logger.info("👋 Shutting down")


app = FastAPI(
    title=settings.APP_NAME,
    version=settings.APP_VERSION,
    description="Platform donasi transparan — Bantu Mereka API",
    lifespan=lifespan,
)

# ── CORS ──────────────────────────────────
app.add_middleware(
    CORSMiddleware,
    allow_origins=settings.cors_origins_list,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# ── Rate Limiting ──────────────────────────
setup_rate_limit(app)

# ── Static Files (uploaded files — dev only) ─
import os
if os.path.exists("uploads"):
    app.mount("/uploads", StaticFiles(directory="uploads"), name="uploads")

# ── Include Routers ────────────────────────
app.include_router(auth.router)
app.include_router(programs.router)
app.include_router(donations.router)
app.include_router(relawan.router)
app.include_router(laporan.router)
app.include_router(kategori.router)
app.include_router(admin.router)


# ── Health Check ───────────────────────────
@app.get("/api/health")
async def health_check():
    return {
        "status": "ok",
        "app": settings.APP_NAME,
        "version": settings.APP_VERSION,
        "environment": settings.ENVIRONMENT,
    }


# ── Root ───────────────────────────────────
@app.get("/")
async def root():
    return {
        "message": f"Welcome to {settings.APP_NAME} API",
        "docs": "/docs",
        "version": settings.APP_VERSION,
    }
