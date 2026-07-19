"""
MongoDB Database Connection using Motor + Beanie ODM
"""

from motor.motor_asyncio import AsyncIOMotorClient
from beanie import init_beanie
import logging

from app.config import settings

logger = logging.getLogger(__name__)

# Models will be imported here for Beanie initialization
from app.models.program import Program
from app.models.kategori import Kategori
from app.models.donasi import Donasi
from app.models.relawan import Relawan
from app.models.laporan import LaporanBantuan
from app.models.user import User
from app.models.team import Team, Partner, Bank, WhatsappGroup
from app.models.withdrawal import Withdrawal, DistributionActivity, DistributionRecipient
from app.models.audit import AuditLog

client: AsyncIOMotorClient | None = None


async def init_db():
    """Initialize MongoDB connection and Beanie ODM"""
    global client
    client = AsyncIOMotorClient(settings.MONGODB_URL)

    db = client[settings.MONGODB_DB_NAME]

    # Initialize Beanie with all document models
    await init_beanie(
        database=db,
        document_models=[
            Program,
            Kategori,
            Donasi,
            Relawan,
            LaporanBantuan,
            User,
            Team,
            Partner,
            Bank,
            WhatsappGroup,
            Withdrawal,
            DistributionActivity,
            DistributionRecipient,
            AuditLog,
        ],
    )

    logger.info(f"✅ Connected to MongoDB: {settings.MONGODB_DB_NAME}")

    # Create indexes
    await _create_indexes()


async def _create_indexes():
    """Create database indexes for performance"""
    db = client[settings.MONGODB_DB_NAME]

    # Programs
    await db.program.create_index([("is_active", 1), ("is_prioritas", -1)])
    await db.program.create_index([("kategori_id", 1)])
    await db.program.create_index([("slug", 1)], unique=True, sparse=True)

    # Donations
    await db.donasi.create_index([("program_id", 1), ("status", 1)])
    await db.donasi.create_index([("email", 1)])
    await db.donasi.create_index([("midtrans_order_id", 1)], unique=True, sparse=True)

    # Relawan
    await db.relawan.create_index([("email", 1)], unique=True, sparse=True)
    await db.relawan.create_index([("provinsi", 1)])

    # Laporan
    await db.laporan_bantuan.create_index([("admin_status", 1)])
    await db.laporan_bantuan.create_index([("kategori_id", 1)])

    # Users
    await db.user.create_index([("username", 1)], unique=True, sparse=True)
    await db.user.create_index([("email", 1)], unique=True, sparse=True)

    # Audit Logs
    await db.audit_log.create_index([("created_at", -1)])
    await db.audit_log.create_index([("action", 1)])

    # Withdrawals
    await db.withdrawal.create_index([("program_id", 1)])
    await db.withdrawal.create_index([("status", 1)])

    logger.info("📇 Database indexes created")


async def close_db():
    """Close MongoDB connection"""
    global client
    if client:
        client.close()
        logger.info("🔌 MongoDB connection closed")


def get_db():
    """Get database instance"""
    return client[settings.MONGODB_DB_NAME]
