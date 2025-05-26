<?php
require_once "../../config/session.php";
require_once "../../classes/PenghuniKost.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Akses ditolak!");
}

$id = $_GET['id'] ?? null;
if (!$id) die("ID tidak ditemukan!");

$penghuniModel = new PenghuniKost();
$conn = $penghuniModel->getConnection();
$result = $conn->query("SELECT * FROM penghuni WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nomor_kamar = $_POST['nomor_kamar'];
    $durasi_sewa = $_POST['durasi_sewa'];

    if ($penghuniModel->update($id, $nama, $nomor_kamar, $durasi_sewa)) {
        header("Location: daftar_penghuni.php");
        exit;
    } else {
        echo "Gagal update data!";
    }
}
?>

<h2>Edit Data Penghuni</h2>
<form method="post">
    Nama: <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>"><br>
    Nomor Kamar: <input type="text" name="nomor_kamar" value="<?= htmlspecialchars($data['nomor_kamar']) ?>"><br>
    Durasi Sewa: <input type="text" name="durasi_sewa" value="<?= htmlspecialchars($data['durasi_sewa']) ?>"><br>
    <button type="submit">Simpan</button>
</form>
