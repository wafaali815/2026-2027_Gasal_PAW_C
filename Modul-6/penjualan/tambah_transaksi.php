<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pelanggan  = trim($_POST['pelanggan_id'] ?? '');
    $tanggal    = trim($_POST['waktu_transaksi'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    // total awal 0, akan diisi otomatis saat detail transaksi ditambahkan
    $stmt = $koneksi->prepare(
        "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?, ?, 0, ?)"
    );
    $stmt->bind_param("sss", $tanggal, $keterangan, $pelanggan);
    $stmt->execute();
    header("Location: detail.php?id=" . $koneksi->insert_id . "&pesan=transaksi_baru");
    exit;
}

$judul = 'Tambah Transaksi';
$menu  = 'transaksi';
include 'header.php';

$pelanggan = $koneksi->query("SELECT id, nama FROM pelanggan ORDER BY nama");
?>
<h2 class="judul">Tambah Transaksi Baru</h2>

<form class="form-horizontal" method="post" action="tambah_transaksi.php">
  <div class="form-group">
    <label class="col-sm-3 control-label" for="waktu_transaksi">Tanggal</label>
    <div class="col-sm-3">
      <input type="date" class="form-control" id="waktu_transaksi" name="waktu_transaksi"
             value="<?= date('Y-m-d') ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" for="pelanggan_id">Pelanggan</label>
    <div class="col-sm-5">
      <select class="form-control" id="pelanggan_id" name="pelanggan_id" required>
        <option value="" selected disabled>-- Pilih pelanggan --</option>
        <?php while ($p = $pelanggan->fetch_assoc()): ?>
          <option value="<?= htmlspecialchars($p['id']) ?>"><?= htmlspecialchars($p['nama']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" for="keterangan">Keterangan</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" required>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
      <button type="submit" class="btn btn-simpan">Simpan</button>
      <a href="index.php" class="btn btn-hapus">Batal</a>
    </div>
  </div>
</form>
<?php include 'footer.php'; ?>
