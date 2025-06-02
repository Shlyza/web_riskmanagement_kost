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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Penghuni</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button { 
            width: 100%;
            padding: 12px;
            background-color: #007bff; 
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3; 
        }
        .message {
            text-align: center;
            margin-bottom: 15px; 
            padding: 10px;
            border-radius: 4px;
        }
        .message.success {
            background-color: #e6fffa;
            color: #007a5e;
            border: 1px solid #b3fff0;
        }
        .message.error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        .navigation-link { 
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff; 
            text-decoration: none;
            font-weight: 500;
        }
        .navigation-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Data Penghuni</h2>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo (strpos(strtolower($message), 'berhasil') !== false || strpos(strtolower($message), 'sukses') !== false) ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="edit_penghuni.php?id=<?= htmlspecialchars($id ?? '') ?>">
            <div>
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama'] ?? '') ?>" required> 
            </div>
            <div>
                <label for="nomor_kamar">Nomor Kamar:</label>
                <input type="text" id="nomor_kamar" name="nomor_kamar" value="<?= htmlspecialchars($data['nomor_kamar'] ?? '') ?>" required> 
            </div>
            <div>
                <label for="durasi_sewa">Durasi Sewa:</label>
                <input type="text" id="durasi_sewa" name="durasi_sewa" value="<?= htmlspecialchars($data['durasi_sewa'] ?? '') ?>" placeholder="Contoh: 1 Tahun, 6 Bulan" required> 
            </div>
            <button type="submit">Update Data</button> 
        </form>

        <a href="daftar_penghuni.php" class="navigation-link">Kembali ke Daftar Penghuni</a>
    </div>
</body>
</html>
