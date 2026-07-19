<?php
session_start();
define('BASE_URL', 'http://app.bantumereka.org');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Panji321');
define('DB_NAME', 'bantumereka_app');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Midtrans config (mode sandbox)
define('MIDTRANS_SERVER_KEY', 'SB-Mid-server-xxxxxxxx');
define('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-xxxxxxxx');
define('MIDTRANS_IS_PRODUCTION', false);
?>