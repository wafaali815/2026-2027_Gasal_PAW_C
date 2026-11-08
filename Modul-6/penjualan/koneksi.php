<?php
// Koneksi ke database penjualan (sesuaikan user/password MySQL Anda)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "penjualan";

try {
    $koneksi = new mysqli($host, $user, $pass, $db);
    $koneksi->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Koneksi database gagal: " . htmlspecialchars($e->getMessage()));
}

// Format angka menjadi rupiah, contoh: 65000 -> Rp 65.000
function rp($angka)
{
    return "Rp " . number_format((int)$angka, 0, ',', '.');
}
