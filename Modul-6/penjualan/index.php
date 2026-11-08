<?php
require 'koneksi.php';
$judul = 'Data Transaksi';
$menu  = 'transaksi';
include 'header.php';

$hasil = $koneksi->query(
    "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama AS pelanggan
     FROM transaksi t
     JOIN pelanggan p ON p.id = t.pelanggan_id
     ORDER BY t.id"
);
$pesan = $_GET['pesan'] ?? '';
?>
<div class="row">
  <div class="col-sm-9"><h2 class="judul">Data Transaksi (Master)</h2></div>
  <div class="col-sm-3 text-right" style="padding-top:15px">
    <a href="tambah_transaksi.php" class="btn btn-simpan btn-sm">Tambah Transaksi</a>
  </div>
</div>

<?php if ($pesan === 'hapus_gagal'): ?>
  <div class="alert alert-danger">Transaksi tidak ditemukan.</div>
<?php endif; ?>

<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th style="width:50px">No</th>
      <th>Tanggal</th>
      <th>Pelanggan</th>
      <th>Keterangan</th>
      <th class="text-money">Total</th>
      <th style="width:90px">Tindakan</th>
    </tr>
  </thead>
  <tbody>
  <?php $no = 1; while ($row = $hasil->fetch_assoc()): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= date('d-m-Y', strtotime($row['waktu_transaksi'])) ?></td>
      <td><?= htmlspecialchars($row['pelanggan']) ?></td>
      <td><?= htmlspecialchars($row['keterangan']) ?></td>
      <td class="text-money"><?= rp($row['total']) ?></td>
      <td><a href="detail.php?id=<?= (int)$row['id'] ?>" class="btn btn-primary btn-xs">Detail</a></td>
    </tr>
  <?php endwhile; ?>
  <?php if ($no === 1): ?>
    <tr><td colspan="6" class="text-center">Belum ada transaksi.</td></tr>
  <?php endif; ?>
  </tbody>
</table>
<?php include 'footer.php'; ?>
