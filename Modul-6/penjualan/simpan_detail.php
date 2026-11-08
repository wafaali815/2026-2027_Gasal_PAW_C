<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$transaksi_id = (int)($_POST['transaksi_id'] ?? 0);
$barang_id    = (int)($_POST['barang_id'] ?? 0);
$qty          = (int)($_POST['qty'] ?? 0);

$kembali = "detail.php?id=" . $transaksi_id;

if ($transaksi_id < 1 || $barang_id < 1 || $qty < 1) {
    header("Location: $kembali&pesan=invalid");
    exit;
}

$koneksi->begin_transaction();
try {
    // 1. Ambil harga barang dari database (bukan dari form) agar tidak bisa dimanipulasi
    $stmt = $koneksi->prepare("SELECT harga FROM barang WHERE id = ?");
    $stmt->bind_param("i", $barang_id);
    $stmt->execute();
    $barang = $stmt->get_result()->fetch_assoc();
    if (!$barang) {
        throw new RuntimeException('invalid');
    }

    // 2. Simpan detail. Primary key (transaksi_id, barang_id) menolak barang yang sama dua kali.
    $stmt = $koneksi->prepare(
        "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("iiii", $transaksi_id, $barang_id, $barang['harga'], $qty);
    $stmt->execute();

    // 3. Hitung ulang total transaksi = jumlah (harga x qty) seluruh detail milik transaksi ini
    $stmt = $koneksi->prepare(
        "UPDATE transaksi
         SET total = (SELECT COALESCE(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = ?)
         WHERE id = ?"
    );
    $stmt->bind_param("ii", $transaksi_id, $transaksi_id);
    $stmt->execute();

    $koneksi->commit();
    header("Location: $kembali&pesan=tambah_detail");
} catch (mysqli_sql_exception $e) {
    $koneksi->rollback();
    // 1062 = duplicate entry (barang sudah ada pada transaksi), selain itu data tidak valid
    $kode = ($e->getCode() == 1062) ? 'duplikat' : 'invalid';
    header("Location: $kembali&pesan=$kode");
} catch (RuntimeException $e) {
    $koneksi->rollback();
    header("Location: $kembali&pesan=invalid");
}
exit;
