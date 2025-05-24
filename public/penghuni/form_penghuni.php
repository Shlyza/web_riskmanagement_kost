<?php
require_once "../../config/session.php";
require_once "../../classes/PenghuniKost.php";

if (!isPenghuni()) {
    die("Akses hanya untuk penghuni kost.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $kamar = $_POST['kamar'];
    $durasi = $_POST['durasi'];
    $user_id = $_SESSION['user']['id']; // ambil ID user dari session

    $penghuni = new PenghuniKost($nama, $kamar, $durasi, $user_id);
    if ($penghuni->simpan()) {
        echo "Data penghuni berhasil disimpan!";
    } else {
        echo "Gagal menyimpan data.";
    }
}
?>

<h2>Lengkapi Data Penghuni Kost</h2>
<form method="post">
    Nama: <input type="text" name="nama" required><br>
    Nomor Kamar: <input type="text" name="kamar" required><br>
    Durasi Sewa: <input type="text" name="durasi" required><br>
    <button type="submit">Simpan</button>
</form>
