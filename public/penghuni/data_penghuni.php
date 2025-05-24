<?php
require_once "../../config/session.php";
require_once "../../classes/Database.php";

if (!isPenghuni()) {
    die("Akses hanya untuk penghuni.");
}

$db = new Database();
$conn = $db->getConnection();

$user_id = $_SESSION['user']['id'];
$sql = "SELECT * FROM penghuni WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    echo "<h3>Data Penghuni Kamu</h3>";
    echo "Nama: " . $data['nama'] . "<br>";
    echo "Kamar: " . $data['nomor_kamar'] . "<br>";
    echo "Durasi: " . $data['durasi_sewa'] . "<br>";
} else {
    echo "Kamu belum isi data kost.";
}
?>
