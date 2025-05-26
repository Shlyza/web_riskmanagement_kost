<?php
require_once "../../config/session.php";
require_once "../../classes/PenghuniKost.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Akses ditolak!");
}

$id = $_GET['id'] ?? null;
if ($id) {
    $penghuniModel = new PenghuniKost();
    if ($penghuniModel->hapus($id)) {
        header("Location: daftar_penghuni.php");
        exit;
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "ID tidak ditemukan!";
}
