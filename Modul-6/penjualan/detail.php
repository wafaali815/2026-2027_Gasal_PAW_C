<?php
require 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);

// ---- Data master: transaksi + nama pelanggan ----
$stmt = $koneksi->prepare(
    "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama AS pelanggan
     FROM transaksi t
     JOIN pelanggan p ON p.id = t.pelanggan_id
     WHERE t.id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$master = $stmt->get_result()->fetch_assoc();

if (!$master) {
    header("Location: index.php?pesan=hapus_gagal");
    exit;
}

// ---- Navigasi antar data master (sebelumnya / berikutnya) ----
$prev = $koneksi->query("SELECT MAX(id) FROM transaksi WHERE id < $id")->fetch_row()[0];
$next = $koneksi->query("SELECT MIN(id) FROM transaksi WHERE id > $id")->fetch_row()[0];

// ---- Data detail: barang pada transaksi ini ----
$stmt = $koneksi->prepare(
    "SELECT d.barang_id, b.kode_barang, b.nama_barang, d.harga, d.qty, d.harga * d.qty AS subtotal
     FROM transaksi_detail d
     JOIN barang b ON b.id = d.barang_id
     WHERE d.transaksi_id = ?
     ORDER BY b.kode_barang"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$detail = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// id barang yang sudah masuk detail -> tidak boleh dipilih lagi
$terpakai = array_map('intval', array_column($detail, 'barang_id'));

// ---- Daftar barang untuk dropdown ----
$barang = $koneksi->query("SELECT id, kode_barang, nama_barang, harga FROM barang ORDER BY kode_barang")
                  ->fetch_all(MYSQLI_ASSOC);
$sisa = 0;
foreach ($barang as $b) {
    if (!in_array((int)$b['id'], $terpakai, true)) {
        $sisa++;
    }
}

$pesan = $_GET['pesan'] ?? '';
$judul = 'Detail Transaksi #' . $id;
$menu  = 'transaksi';
include 'header.php';
?>
<div class="row">
  <div class="col-sm-8"><h2 class="judul">Master Detail Transaksi</h2></div>
  <div class="col-sm-4 text-right" style="padding-top:15px">
    <?php if ($prev): ?>
      <a href="detail.php?id=<?= (int)$prev ?>" class="btn btn-default btn-sm">&laquo; Sebelumnya</a>
    <?php else: ?>
      <span class="btn btn-default btn-sm disabled">&laquo; Sebelumnya</span>
    <?php endif; ?>
    <?php if ($next): ?>
      <a href="detail.php?id=<?= (int)$next ?>" class="btn btn-default btn-sm">Berikutnya &raquo;</a>
    <?php else: ?>
      <span class="btn btn-default btn-sm disabled">Berikutnya &raquo;</span>
    <?php endif; ?>
  </div>
</div>

<?php if ($pesan === 'tambah_detail'): ?>
  <div class="alert alert-success">Detail transaksi berhasil ditambahkan dan total transaksi telah diperbarui.</div>
<?php elseif ($pesan === 'transaksi_baru'): ?>
  <div class="alert alert-success">Transaksi baru berhasil dibuat. Silakan tambahkan barang pada detail di bawah.</div>
<?php elseif ($pesan === 'duplikat'): ?>
  <div class="alert alert-danger">Barang tersebut sudah ada pada transaksi ini dan tidak dapat diinput dua kali.</div>
<?php elseif ($pesan === 'invalid'): ?>
  <div class="alert alert-danger">Data tidak valid. Pilih barang dan isi jumlah (qty) minimal 1.</div>
<?php endif; ?>

<!-- ===================== MASTER ===================== -->
<div class="panel panel-primary">
  <div class="panel-heading"><strong>Master: Transaksi #<?= (int)$master['id'] ?></strong></div>
  <div class="panel-body">
    <dl class="dl-horizontal" style="margin-bottom:0">
      <dt>No. Transaksi</dt><dd><?= (int)$master['id'] ?></dd>
      <dt>Tanggal</dt><dd><?= date('d-m-Y', strtotime($master['waktu_transaksi'])) ?></dd>
      <dt>Pelanggan</dt><dd><?= htmlspecialchars($master['pelanggan']) ?></dd>
      <dt>Keterangan</dt><dd><?= htmlspecialchars($master['keterangan']) ?></dd>
      <dt>Total</dt><dd><strong><?= rp($master['total']) ?></strong></dd>
    </dl>
  </div>
</div>

<!-- ===================== DETAIL ===================== -->
<div class="panel panel-info">
  <div class="panel-heading"><strong>Detail: Barang pada transaksi ini</strong></div>
  <table class="table table-bordered" style="margin-bottom:0">
    <thead>
      <tr>
        <th style="width:50px">No</th>
        <th>Kode</th>
        <th>Nama Barang</th>
        <th class="text-money">Harga</th>
        <th class="text-money">Qty</th>
        <th class="text-money">Subtotal</th>
      </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($detail as $d): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($d['kode_barang']) ?></td>
        <td><?= htmlspecialchars($d['nama_barang']) ?></td>
        <td class="text-money"><?= rp($d['harga']) ?></td>
        <td class="text-money"><?= (int)$d['qty'] ?></td>
        <td class="text-money"><?= rp($d['subtotal']) ?></td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$detail): ?>
      <tr><td colspan="6" class="text-center">Belum ada barang pada transaksi ini.</td></tr>
    <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="5" class="text-right">Total</th>
        <th class="text-money"><?= rp($master['total']) ?></th>
      </tr>
    </tfoot>
  </table>
</div>

<!-- ===================== FORM INPUT DETAIL ===================== -->
<h4>Tambah Barang ke Transaksi</h4>
<?php if ($sisa === 0): ?>
  <div class="alert alert-warning">Semua barang sudah dimasukkan ke transaksi ini.</div>
<?php else: ?>
<form class="form-inline" method="post" action="simpan_detail.php">
  <input type="hidden" name="transaksi_id" value="<?= (int)$master['id'] ?>">
  <div class="form-group">
    <label for="barang_id">Barang</label>
    <select class="form-control" id="barang_id" name="barang_id" required>
      <option value="" selected disabled>-- Pilih barang --</option>
      <?php foreach ($barang as $b):
          $sudah = in_array((int)$b['id'], $terpakai, true); ?>
        <option value="<?= (int)$b['id'] ?>" data-harga="<?= (int)$b['harga'] ?>"<?= $sudah ? ' disabled' : '' ?>>
          <?= htmlspecialchars($b['kode_barang'] . ' - ' . $b['nama_barang']) ?><?= $sudah ? ' (sudah dipilih)' : '' ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label for="harga_info">Harga</label>
    <input type="text" class="form-control" id="harga_info" value="-" readonly style="width:120px">
  </div>
  <div class="form-group">
    <label for="qty">Qty</label>
    <input type="number" class="form-control" id="qty" name="qty" min="1" value="1" required style="width:80px">
  </div>
  <button type="submit" class="btn btn-simpan">Simpan</button>
</form>
<script>
  // Menampilkan harga barang yang dipilih (harga final tetap diambil dari database saat disimpan)
  document.getElementById('barang_id').addEventListener('change', function () {
    var harga = this.options[this.selectedIndex].getAttribute('data-harga');
    document.getElementById('harga_info').value = 'Rp ' + Number(harga).toLocaleString('id-ID');
  });
</script>
<?php endif; ?>

<p style="margin-top:20px"><a href="index.php" class="btn btn-default btn-sm">&larr; Kembali ke daftar transaksi</a></p>
<?php include 'footer.php'; ?>
