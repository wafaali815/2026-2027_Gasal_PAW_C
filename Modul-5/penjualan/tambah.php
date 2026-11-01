<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    $stmt = $koneksi->prepare("INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $telp, $alamat);
    $stmt->execute();
    header("Location: index.php?pesan=tambah");
    exit;
}

include 'header.php';
?>
<h2 class="judul">Tambah Data Master Supplier Baru</h2>

<form class="form-horizontal" method="post" action="tambah.php">
  <div class="form-group">
    <label class="col-sm-3 control-label" for="nama">Nama</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" maxlength="100" required>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" for="telp">Telp</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="telp" name="telp" placeholder="telp" maxlength="12" required>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" for="alamat">Alamat</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="alamat" name="alamat" placeholder="alamat" required>
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
