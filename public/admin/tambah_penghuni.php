<?php
require_once "../../classes/PenghuniKost.php";
require_once "../../config/session.php";

if (!isAdmin()) {
    die("Akses ditolak! Halaman ini hanya untuk admin.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kamar = $_POST['kamar'];
    $durasi = $_POST['durasi'];

    $penghuni = new PenghuniKost($nama, $kamar, $durasi);
    if ($penghuni->simpan()) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Gagal menyimpan data.";
    }
}
?>

<form method="post">
    Nama: <input type="text" name="nama"><br>
    Nomor Kamar: <input type="text" name="kamar"><br>
    Durasi Sewa: <input type="text" name="durasi"><br>
    <button type="submit">Simpan</button>
</form>
