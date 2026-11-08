<?php
require 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);

// Ambil data barang (nama dipakai untuk pesan notifikasi)
$stmt = $koneksi->prepare("SELECT nama_barang FROM barang WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$barang = $stmt->get_result()->fetch_assoc();

if (!$barang) {
    header("Location: barang.php?pesan=tidak_ada");
    exit;
}
$nama = urlencode($barang['nama_barang']);

// 1. Cek dulu apakah barang sudah dipakai pada tabel transaksi_detail
$stmt = $koneksi->prepare("SELECT COUNT(*) FROM transaksi_detail WHERE barang_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dipakai = $stmt->get_result()->fetch_row()[0];

if ($dipakai > 0) {
    // 2a. Sudah dipakai: data tidak boleh dihapus, tampilkan notifikasi
    header("Location: barang.php?pesan=dipakai&nama=$nama");
    exit;
}

// 2b. Belum dipakai: hapus seperti biasa
try {
    $stmt = $koneksi->prepare("DELETE FROM barang WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: barang.php?pesan=hapus&nama=$nama");
} catch (mysqli_sql_exception $e) {
    // pengaman tambahan jika foreign key menolak penghapusan
    header("Location: barang.php?pesan=dipakai&nama=$nama");
}
exit;
