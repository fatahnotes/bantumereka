# 📦 Database — Bantu Mereka

Folder ini berisi file database untuk development & kolaborasi tim.

## 📁 File yang Tersedia

| File | Isi | Kegunaan |
|------|-----|----------|
| `schema.sql` | Struktur tabel saja (tanpa data) | Setup awal di environment baru |
| `seed.sql` | Data awal saja (insert statements) | Isi ulang data development |
| `bantumereka_app.sql` | **Full dump** — struktur + data | Restore database lengkap |

## 🚀 Cara Setup Database Baru (Untuk Tim Member Baru)

### Prasyarat
- MySQL 8.0+ sudah terinstall
- Akses terminal / command prompt

### Langkah 1: Buat Database
```sql
mysql -u root -p
CREATE DATABASE bantumereka_app CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
EXIT;
```

### Langkah 2: Import Database
```bash
# Dari folder project root
mysql -u root -p bantumereka_app < database/bantumereka_app.sql
```

### Langkah 3: Setup Konfigurasi
```bash
# Copy template konfigurasi
cp config.example.php config.php

# Edit config.php dan sesuaikan DB_USER, DB_PASS sesuai environment kamu
```

### Langkah 4: Jalankan di Browser
Buka `http://localhost/bantumereka` di browser.

---

## 🔄 Menyegarkan Data Development

Saat ada perubahan struktur tabel atau data baru dari development:

```bash
# Export ulang full dump
mysqldump -u root -p --routines --triggers bantumereka_app > database/bantumereka_app.sql

# Export ulang schema only
mysqldump -u root -p --no-data --routines --triggers bantumereka_app > database/schema.sql

# Export ulang data only
mysqldump -u root -p --no-create-info --complete-insert bantumereka_app > database/seed.sql
```

Lalu commit dan push ke GitHub.

---

## ⚠️ PENTING — Jangan Commit `config.php`!

File `config.php` sudah masuk `.gitignore` karena berisi password database & API keys.
Setiap member tim harus membuat `config.php` sendiri dari `config.example.php`.
