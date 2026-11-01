<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int)($_POST['id'] ?? 0);
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    $stmt = $koneksi->prepare("UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nama, $telp, $alamat, $id);
    $stmt->execute();
    header("Location: index.php?pesan=update");
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$stmt = $koneksi->prepare("SELECT id, nama, telp, alamat FROM supplier WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: index.php");
    exit;
}

include 'header.php';
?>
<h2 class="judul">Edit Data Master Supplier</h2>

<form class="form-horizontal" method="post" action="edit.php">
  <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">
  <div class="form-group">
    <label class="col-sm-3 control-label" for="nama">Nama</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="nama" name="nama" maxlength="100"
             value="<?= htmlspecialchars($data['nama']) ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" for="telp">Telp</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="telp" name="telp" maxlength="12"
             value="<?= htmlspecialchars($data['telp']) ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label" for="alamat">Alamat</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="alamat" name="alamat"
             value="<?= htmlspecialchars($data['alamat']) ?>" required>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
      <button type="submit" class="btn btn-simpan">Update</button>
      <a href="index.php" class="btn btn-hapus">Batal</a>
    </div>
  </div>
</form>
<?php include 'footer.php'; ?>
