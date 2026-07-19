# 🤝 Bantu Mereka — Platform Donasi Transparan

Platform donasi modern dengan transparansi penuh. **Donasi 100% tersalurkan tanpa potongan.**

> ⚡ **Stack:** React + TypeScript + Tailwind CSS (Frontend) | FastAPI + MongoDB (Backend)

---

## 📁 Struktur Project

```
bantumereka/
├── backend/                    # FastAPI + MongoDB
│   ├── app/
│   │   ├── models/            # Beanie ODM models
│   │   ├── routers/           # API endpoints
│   │   ├── services/          # Midtrans, Email, Storage
│   │   ├── middleware/        # Rate limit, Audit
│   │   ├── utils/             # Auth, helpers
│   │   ├── config.py          # App configuration
│   │   ├── database.py        # MongoDB connection
│   │   └── main.py            # Entry point
│   ├── seed.py                # Database seeder
│   ├── requirements.txt
│   └── .env.example
├── frontend/                   # React + TypeScript + Tailwind
│   ├── src/
│   │   ├── components/        # Shared UI components
│   │   ├── pages/             # Route pages
│   │   ├── services/          # API client
│   │   └── lib/               # Utilities
│   ├── package.json
│   └── .env.example
├── database/                   # MySQL dump (legacy)
│   ├── schema.sql
│   ├── seed.sql
│   └── bantumereka_app.sql
├── config.example.php          # Legacy PHP config template
└── .gitignore
```

---

## 🚀 Quick Start

### Prasyarat
- **Python 3.12+** & pip
- **Node.js 20+** & npm
- **MongoDB 7+** (local atau MongoDB Atlas)

### 1. Clone & Setup Backend

```bash
cd backend

# Copy & isi .env
cp .env.example .env

# Buat virtual environment
python -m venv venv
source venv/bin/activate  # Windows: venv\Scripts\activate

# Install dependencies
pip install -r requirements.txt

# Run database seeder
python seed.py

# Start server (http://localhost:8000)
uvicorn app.main:app --reload
```

### 2. Setup Frontend

```bash
cd frontend

# Copy & isi .env
cp .env.example .env

# Install dependencies
npm install

# Start dev server (http://localhost:5173)
npm run dev
```

### 3. Akses

| URL | Deskripsi |
|-----|-----------|
| `http://localhost:5173` | Website utama |
| `http://localhost:8000/docs` | API Docs (Swagger) |
| `http://localhost:5173/admin/login` | Admin Panel |

### Default Admin
- Username: `admin`
- Password: `admin123`
- ⚠️ **GANTI PASSWORD SEGERA di production!**

---

## 📡 API Endpoints

### Public
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `GET` | `/api/programs` | List program |
| `GET` | `/api/programs/prioritas` | Program prioritas |
| `GET` | `/api/programs/terbaru` | Program terbaru |
| `GET` | `/api/programs/{id}` | Detail program |
| `GET` | `/api/programs/{id}/ledger` | Public ledger |
| `GET` | `/api/programs/stats` | Statistik dampak |
| `GET` | `/api/kategori` | List kategori |
| `POST` | `/api/donations` | Buat donasi |
| `POST` | `/api/donations/webhook` | Webhook Midtrans |
| `POST` | `/api/relawan/register` | Daftar relawan |
| `POST` | `/api/laporan/kirim` | Kirim laporan |

### Admin (Auth Required)
| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| `POST` | `/api/auth/login` | Login admin |
| `GET` | `/api/admin/dashboard` | Dashboard stats |
| `GET` | `/api/admin/relawan` | List relawan |
| `GET` | `/api/admin/laporan` | List laporan |
| `GET` | `/api/admin/audit-logs` | Audit logs |
| `POST` | `/api/programs` | Buat program |
| `PUT` | `/api/programs/{id}` | Update program |
| `DELETE` | `/api/programs/{id}` | Hapus program |

---

## 🔧 Environment Variables

### Backend (.env)

| Variable | Deskripsi | Default |
|----------|-----------|---------|
| `MONGODB_URL` | MongoDB connection string | `mongodb://localhost:27017` |
| `MONGODB_DB_NAME` | Database name | `bantumereka` |
| `JWT_SECRET_KEY` | JWT signing key | (wajib diisi) |
| `MIDTRANS_SERVER_KEY` | Midtrans server key | — |
| `MIDTRANS_CLIENT_KEY` | Midtrans client key | — |
| `RECAPTCHA_SECRET_KEY` | Google reCAPTCHA secret | — |
| `RESEND_API_KEY` | Resend email API key | — |

---

## 🏗️ Production Deployment

### Backend
```bash
uvicorn app.main:app --host 0.0.0.0 --port 8000 --workers 4
```

### Frontend
```bash
npm run build
# Deploy dist/ ke static hosting (Vercel, Netlify, Nginx)
```

### Docker (opsional)
```dockerfile
# Backend
FROM python:3.12-slim
WORKDIR /app
COPY backend/requirements.txt .
RUN pip install -r requirements.txt
COPY backend/ .
CMD ["uvicorn", "app.main:app", "--host", "0.0.0.0", "--port", "8000"]
```

---

## ✨ Fitur Utama

- 🏠 **Landing Page** dengan slider Program Prioritas, Terbaru, per Kategori
- 💰 **Donasi via Midtrans Snap** (VA, GoPay, OVO, QRIS, Kartu)
- 📋 **Form Relawan** multi-step dengan upload foto
- 📤 **Form Kirim Data** penerima manfaat + upload PDF
- 🔗 **Public Ledger** transparansi dengan hash-chain
- 🛡️ **Admin Dashboard** — kelola program, relawan, laporan
- 📊 **Statistik dampak** real-time
- 🚦 **Rate limiting** & reCAPTCHA anti-spam
- 📧 **Email receipt** otomatis via Resend
- 🔐 **JWT Authentication** untuk admin
- 📱 **Mobile-first** responsive design
- 📝 **Audit log** semua transaksi

---

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b fitur/namafitur`)
3. Commit perubahan (`git commit -m 'Tambah fitur X'`)
4. Push ke branch (`git push origin fitur/namafitur`)
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini adalah milik **Yayasan Bantu Mereka**. 
Dibangun dengan ❤️ untuk kemanusiaan.
