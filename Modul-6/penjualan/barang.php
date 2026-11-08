<?php
require 'koneksi.php';
$judul = 'Data Master Barang';
$menu  = 'barang';
include 'header.php';

$hasil = $koneksi->query(
    "SELECT b.id, b.kode_barang, b.nama_barang, b.harga, b.stok, s.nama AS supplier
     FROM barang b
     JOIN supplier s ON s.id = b.supplier_id
     ORDER BY b.kode_barang"
);
$pesan = $_GET['pesan'] ?? '';
$nama  = $_GET['nama'] ?? '';
?>
<h2 class="judul">Data Master Barang</h2>

<?php if ($pesan === 'hapus'): ?>
  <div class="alert alert-success">Barang <strong><?= htmlspecialchars($nama) ?></strong> berhasil dihapus.</div>
<?php elseif ($pesan === 'dipakai'): ?>
  <div class="alert alert-danger">Barang <strong><?= htmlspecialchars($nama) ?></strong> tidak dapat dihapus karena masih digunakan pada transaksi.</div>
<?php elseif ($pesan === 'tidak_ada'): ?>
  <div class="alert alert-warning">Data barang tidak ditemukan.</div>
<?php endif; ?>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th style="width:50px">No</th>
      <th>Kode</th>
      <th>Nama Barang</th>
      <th class="text-money">Harga</th>
      <th class="text-money">Stok</th>
      <th>Supplier</th>
      <th style="width:90px">Tindakan</th>
    </tr>
  </thead>
  <tbody>
  <?php $no = 1; while ($row = $hasil->fetch_assoc()): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['kode_barang']) ?></td>
      <td><?= htmlspecialchars($row['nama_barang']) ?></td>
      <td class="text-money"><?= rp($row['harga']) ?></td>
      <td class="text-money"><?= (int)$row['stok'] ?></td>
      <td><?= htmlspecialchars($row['supplier']) ?></td>
      <td>
        <a href="hapus_barang.php?id=<?= (int)$row['id'] ?>" class="btn btn-hapus btn-xs"
           onclick="return confirm('Anda yakin akan menghapus barang ini?');">Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php include 'footer.php'; ?>
