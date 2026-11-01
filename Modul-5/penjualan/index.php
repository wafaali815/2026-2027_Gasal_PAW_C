<?php
require 'koneksi.php';
include 'header.php';

$hasil = $koneksi->query("SELECT id, nama, telp, alamat FROM supplier ORDER BY id");
$pesan = $_GET['pesan'] ?? '';
?>
<div class="row">
  <div class="col-sm-9"><h2 class="judul">Data Master Supplier</h2></div>
  <div class="col-sm-3 text-right" style="padding-top:15px">
    <a href="tambah.php" class="btn btn-simpan btn-sm">Tambah Data</a>
  </div>
</div>

<?php if ($pesan === 'tambah'): ?>
  <div class="alert alert-success">Data supplier berhasil ditambahkan.</div>
<?php elseif ($pesan === 'update'): ?>
  <div class="alert alert-success">Data supplier berhasil diperbarui.</div>
<?php elseif ($pesan === 'hapus'): ?>
  <div class="alert alert-success">Data supplier berhasil dihapus.</div>
<?php elseif ($pesan === 'gagal_hapus'): ?>
  <div class="alert alert-danger">Supplier tidak dapat dihapus karena masih digunakan oleh data barang.</div>
<?php endif; ?>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th style="width:50px">No</th>
      <th>Nama</th>
      <th>Telp</th>
      <th>Alamat</th>
      <th style="width:150px">Tindakan</th>
    </tr>
  </thead>
  <tbody>
  <?php $no = 1; while ($row = $hasil->fetch_assoc()): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['nama']) ?></td>
      <td><?= htmlspecialchars($row['telp']) ?></td>
      <td><?= htmlspecialchars($row['alamat']) ?></td>
      <td>
        <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-edit btn-xs">Edit</a>
        <a href="hapus.php?id=<?= (int)$row['id'] ?>" class="btn btn-hapus btn-xs"
           onclick="return confirm('Anda yakin akan menghapus supplier ini?');">Hapus</a>
      </td>
    </tr>
  <?php endwhile; ?>
  <?php if ($no === 1): ?>
    <tr><td colspan="5" class="text-center">Belum ada data.</td></tr>
  <?php endif; ?>
  </tbody>
</table>
<?php include 'footer.php'; ?>
