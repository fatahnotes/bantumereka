"""
Seed Script — Import data awal ke MongoDB
Jalankan: python seed.py
"""

import asyncio
import sys
import os

sys.path.insert(0, os.path.dirname(__file__))

from motor.motor_asyncio import AsyncIOMotorClient
from beanie import init_beanie
from datetime import datetime
from slugify import slugify
from passlib.context import CryptContext

from app.config import settings
from app.models.kategori import Kategori
from app.models.program import Program
from app.models.user import User
from app.models.team import Team, Partner, Bank, WhatsappGroup
from app.models.donasi import Donasi
from app.models.relawan import Relawan
from app.models.laporan import LaporanBantuan

pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")

# Categories data from existing MySQL
KATEGORI_DATA = [
    "Pangan", "Pendidikan", "Kesehatan", "Bencana Alam",
    "Rumah Ibadah", "Anak Yatim", "Lansia", "Disabilitas",
    "Lingkungan", "Ekonomi", "Sosial", "Kemanusiaan",
]

# WA Groups per provinsi
WA_GROUPS = [
    {"provinsi": "DKI Jakarta", "link_whatsapp": "https://chat.whatsapp.com/xxxxx-jakarta"},
    {"provinsi": "Jawa Barat", "link_whatsapp": "https://chat.whatsapp.com/xxxxx-jabar"},
    {"provinsi": "Jawa Tengah", "link_whatsapp": "https://chat.whatsapp.com/xxxxx-jateng"},
    {"provinsi": "Jawa Timur", "link_whatsapp": "https://chat.whatsapp.com/xxxxx-jatim"},
    {"provinsi": "Banten", "link_whatsapp": "https://chat.whatsapp.com/xxxxx-banten"},
]

BANK_DATA = [
    {"nama_bank": "Bank BSI", "no_rekening": "1234567890", "atas_nama": "Yayasan Bantu Mereka"},
    {"nama_bank": "Bank Mandiri", "no_rekening": "0987654321", "atas_nama": "Yayasan Bantu Mereka"},
    {"nama_bank": "BCA", "no_rekening": "1122334455", "atas_nama": "Yayasan Bantu Mereka"},
]

TEAM_DATA = [
    {"nama": "Ahmad Fauzi", "jabatan": "Founder & CEO", "bio": "Penggiat sosial dan teknologi blockchain", "urutan": 1},
    {"nama": "Siti Nurhaliza", "jabatan": "COO", "bio": "Profesional dengan 10+ tahun di NGO internasional", "urutan": 2},
    {"nama": "Budi Santoso", "jabatan": "CTO", "bio": "Blockchain engineer & full-stack developer", "urutan": 3},
    {"nama": "Dewi Kartika", "jabatan": "CFO", "bio": "Akuntan publik dengan spesialisasi organisasi non-profit", "urutan": 4},
]

PARTNER_DATA = [
    {"nama": "Kitabisa", "website_url": "https://kitabisa.com", "urutan": 1},
    {"nama": "Dompet Dhuafa", "website_url": "https://dompetdhuafa.org", "urutan": 2},
    {"nama": "Rumah Zakat", "website_url": "https://rumahzakat.org", "urutan": 3},
    {"nama": "ACT", "website_url": "https://act.id", "urutan": 4},
]


async def seed():
    """Import all seed data"""
    print("🌱 Starting seed...")

    # Connect to MongoDB
    client = AsyncIOMotorClient(settings.MONGODB_URL)
    db = client[settings.MONGODB_DB_NAME]

    await init_beanie(
        database=db,
        document_models=[
            Kategori, Program, User, Team, Partner, Bank,
            WhatsappGroup, Donasi, Relawan, LaporanBantuan,
        ],
    )

    # ── Kategori ──
    print("📂 Seeding kategori...")
    for nama in KATEGORI_DATA:
        existing = await Kategori.find_one({"nama": nama})
        if not existing:
            kat = Kategori(nama=nama, slug=slugify(nama))
            await kat.insert()
            print(f"  ✓ {nama}")

    # ── Admin User ──
    print("👤 Seeding admin user...")
    existing_admin = await User.find_one({"username": "admin"})
    if not existing_admin:
        admin = User(
            username="admin",
            password_hash=pwd_context.hash("admin123"),
            nama="Super Admin",
            email="admin@bantumereka.org",
            role="superadmin",
        )
        await admin.insert()
        print("  ✓ admin / admin123 (GANTI PASSWORD SEGERA!)")

    # ── WA Groups ──
    print("💬 Seeding WA Groups...")
    for group in WA_GROUPS:
        existing = await WhatsappGroup.find_one({"provinsi": group["provinsi"]})
        if not existing:
            await WhatsappGroup(**group).insert()
            print(f"  ✓ {group['provinsi']}")

    # ── Bank ──
    print("🏦 Seeding bank accounts...")
    for bank in BANK_DATA:
        existing = await Bank.find_one({"no_rekening": bank["no_rekening"]})
        if not existing:
            await Bank(**bank).insert()
            print(f"  ✓ {bank['nama_bank']}")

    # ── Team ──
    print("👥 Seeding team...")
    for member in TEAM_DATA:
        existing = await Team.find_one({"nama": member["nama"]})
        if not existing:
            await Team(**member).insert()
            print(f"  ✓ {member['nama']}")

    # ── Partners ──
    print("🤝 Seeding partners...")
    for partner in PARTNER_DATA:
        existing = await Partner.find_one({"nama": partner["nama"]})
        if not existing:
            await Partner(**partner).insert()
            print(f"  ✓ {partner['nama']}")

    # ── Sample Program ──
    print("📋 Seeding sample programs...")
    kategori_list = await Kategori.find_all().to_list()
    if kategori_list:
        pangan = next((k for k in kategori_list if k.nama == "Pangan"), kategori_list[0])
        pendidikan = next((k for k in kategori_list if k.nama == "Pendidikan"), kategori_list[0])
        kesehatan = next((k for k in kategori_list if k.nama == "Kesehatan"), kategori_list[0])

        sample_programs = [
            {
                "nama": "Bantu Makan 1000 Anak Yatim",
                "deskripsi": "Program penyediaan makanan bergizi untuk anak yatim di Jakarta",
                "deskripsi_lengkap": "Program ini bertujuan menyediakan makanan bergizi bagi 1000 anak yatim di wilayah DKI Jakarta selama satu bulan penuh.",
                "target_donasi": 50000000,
                "kategori_id": str(pangan.id),
                "is_active": True,
                "is_prioritas": True,
                "is_verified": True,
                "provinsi": "DKI Jakarta",
            },
            {
                "nama": "Beasiswa Pendidikan Untuk Pelajar Kurang Mampu",
                "deskripsi": "Bantuan biaya pendidikan untuk 500 pelajar SD-SMA",
                "deskripsi_lengkap": "Program beasiswa untuk membantu pelajar dari keluarga kurang mampu agar tetap bisa melanjutkan pendidikan.",
                "target_donasi": 100000000,
                "kategori_id": str(pendidikan.id),
                "is_active": True,
                "is_prioritas": True,
                "is_verified": True,
                "provinsi": "Jawa Barat",
            },
            {
                "nama": "Pengobatan Gratis Untuk Lansia",
                "deskripsi": "Layanan kesehatan gratis untuk lansia di pedesaan",
                "deskripsi_lengkap": "Program pengobatan gratis yang menyasar lansia di daerah pedesaan yang sulit mengakses fasilitas kesehatan.",
                "target_donasi": 75000000,
                "kategori_id": str(kesehatan.id),
                "is_active": True,
                "is_prioritas": False,
                "is_verified": True,
                "provinsi": "Jawa Tengah",
            },
        ]

        for prog_data in sample_programs:
            existing = await Program.find_one({"nama": prog_data["nama"]})
            if not existing:
                prog_data["slug"] = slugify(prog_data["nama"])
                prog = Program(**prog_data)
                await prog.insert()
                print(f"  ✓ {prog_data['nama']}")

    client.close()
    print("\n✅ Seed completed!")
    print("⚠️  JANGAN LUPA ganti password admin di production!")


if __name__ == "__main__":
    asyncio.run(seed())
