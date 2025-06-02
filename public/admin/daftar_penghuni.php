<?php
require_once "../../config/session.php"; 
require_once "../../classes/PenghuniKost.php"; 

if ($_SESSION['user']['role'] !== 'admin') { 
    die("Akses ditolak!"); 
}

$penghuniModel = new PenghuniKost(); 
$data = $penghuniModel->ambilSemua(); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penghuni Kost</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .navigation-links {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .navigation-links a {
            text-decoration: none;
            color: #007bff;
            padding: 8px 12px;
            border-radius: 5px;
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }
        .navigation-links a:hover {
            background-color: #007bff;
            color: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-links a {
            text-decoration: none;
            padding: 6px 10px;
            margin-right: 5px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .edit-link {
            background-color: #ffc107;
            color: #333;
        }
        .edit-link:hover {
            background-color: #e0a800;
        }
        .delete-link {
            background-color: #dc3545;
            color: white;
        }
        .delete-link:hover {
            background-color: #c82333;
        }
        .add-button-container {
            margin-bottom: 20px;
            text-align: right;
        }
        .add-button {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .add-button:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Penghuni Kost</h2>

        <div class="navigation-links">
            <a href="../dashboard.php">Home</a>
            <a href="../admin/daftar_keluhan.php">Daftar Keluhan</a>
            <a href="../admin/daftar_monitoring.php">Daftar Monitoring</a>
        </div>

        <div class="add-button-container">
            <a href="tambah_penghuni.php" class="add-button">Tambah Penghuni Baru</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Nomor Kamar</th>
                    <th>Durasi Sewa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['id']) ?></td>
                    <td><?= htmlspecialchars($p['nama']) ?></td>
                    <td><?= htmlspecialchars($p['nomor_kamar']) ?></td>
                    <td><?= htmlspecialchars($p['durasi_sewa']) ?></td>
                    <td class="action-links">
                        <a href="edit_penghuni.php?id=<?= $p['id'] ?>" class="edit-link">Edit</a>
                        <a href="hapus_penghuni.php?id=<?= $p['id'] ?>" class="delete-link" onclick="return confirm('Yakin ingin menghapus data penghuni ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Belum ada data penghuni.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>