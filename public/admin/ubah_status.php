<?php
require_once "../../config/session.php";
require_once "../../classes/Database.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Akses ditolak!");
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];
    $statusValid = ['proses', 'selesai'];

    if (!in_array($status, $statusValid)) {
        die("Status tidak valid.");
    }

    $db = new Database();
    $conn = $db->getConnection();
    //menggunakan getter untuk mengakses protected Database

    $sql = "UPDATE keluhan SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    header("Location: daftar_keluhan.php");
    exit;
}
?>
