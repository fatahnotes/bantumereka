<?php
/**
 * Bantu Mereka - Konfigurasi Aplikasi
 * ====================================
 * 
 * CARA SETUP UNTUK DEVELOPMENT LOKAL:
 * 1. Copy file ini menjadi config.php:  cp config.example.php config.php
 * 2. Sesuaikan nilai DB_HOST, DB_USER, DB_PASS, DB_NAME
 * 3. Import database: lihat folder /database untuk file SQL
 * 
 * ALTERNATIF: Gunakan environment variable (.env style)
 * Cukup set variabel berikut di environment server:
 *   DB_HOST, DB_USER, DB_PASS, DB_NAME
 *   MIDTRANS_SERVER_KEY, MIDTRANS_CLIENT_KEY
 */

session_start();

// ==================== BASE URL ====================
// Ganti sesuai domain production kamu
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost/bantumereka');

// ==================== DATABASE ====================
// Gunakan env var jika tersedia, jika tidak, isi manual di sini
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'bantumereka_app');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ==================== MIDTRANS ====================
// Gunakan env var untuk production / isi manual untuk development
define('MIDTRANS_SERVER_KEY', getenv('MIDTRANS_SERVER_KEY') ?: 'SB-Mid-server-xxxxxxxx');
define('MIDTRANS_CLIENT_KEY', getenv('MIDTRANS_CLIENT_KEY') ?: 'SB-Mid-client-xxxxxxxx');
define('MIDTRANS_IS_PRODUCTION', filter_var(getenv('MIDTRANS_IS_PRODUCTION') ?: 'false', FILTER_VALIDATE_BOOLEAN));
