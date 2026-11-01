<?php
require 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);

try {
    $stmt = $koneksi->prepare("DELETE FROM supplier WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: index.php?pesan=hapus");
} catch (mysqli_sql_exception $e) {
    // Gagal karena masih direferensikan tabel barang (foreign key)
    header("Location: index.php?pesan=gagal_hapus");
}
exit;
