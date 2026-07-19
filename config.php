<?php
/**
 * Bantu Mereka - Konfigurasi Aplikasi
 * ====================================
 * File ini TIDAK di-commit ke GitHub (ada di .gitignore).
 * Member baru: copy dari config.example.php dan isi credential masing-masing.
 */

session_start();
define('BASE_URL', getenv('BASE_URL') ?: 'http://app.bantumereka.org');

// ── Database ────────────────────────────────────
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: 'Panji321');
define('DB_NAME', getenv('DB_NAME') ?: 'bantumereka_app');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// ── Midtrans (mode sandbox) ─────────────────────
define('MIDTRANS_SERVER_KEY', getenv('MIDTRANS_SERVER_KEY') ?: 'SB-Mid-server-xxxxxxxx');
define('MIDTRANS_CLIENT_KEY', getenv('MIDTRANS_CLIENT_KEY') ?: 'SB-Mid-client-xxxxxxxx');
define('MIDTRANS_IS_PRODUCTION', false);
?>