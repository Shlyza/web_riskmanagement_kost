
<?php
require_once "../../config/session.php";
require_once "../../classes/Monitoring.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Akses ditolak!");
}

$monitoring = new Monitoring();
$data = $monitoring->ambilSemuaMonitoring();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Penanganan Keluhan</title>
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
            width: 95%; /* Lebih lebar untuk menampung banyak kolom */
            max-width: 1200px;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            overflow-x: auto; /* Tambahkan scroll horizontal jika tabel terlalu lebar */
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
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .navigation-links a:hover {
            background-color: #007bff;
            color: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 0.95em; /* Sedikit perkecil font jika kolom banyak */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px; /* Sedikit kurangi padding jika kolom banyak */
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            white-space: nowrap; /* Agar header tidak terpotong */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td img {
            max-width: 100px; /* Batasi lebar gambar */
            height: auto;
            border-radius: 4px;
            display: block; /* Untuk menghilangkan spasi ekstra di bawah gambar */
        }
        .status-belum_diproses {
            background-color: #ffebee; /* Merah muda */
            color: #c62828;
            padding: 5px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-proses {
            background-color: #fff9c4; /* Kuning muda */
            color: #f57f17;
            padding: 5px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-selesai {
            background-color: #e8f5e9; /* Hijau muda */
            color: #2e7d32;
            padding: 5px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Monitoring Penanganan Keluhan</h2>

        <div class="navigation-links">
            <a href="../dashboard.php">Home</a>
            <a href="../admin/daftar_penghuni.php">Daftar Penghuni</a>
            <a href="../admin/daftar_keluhan.php">Daftar Keluhan</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Penghuni</th>
                    <th>Keluhan</th>
                    <th>Deskripsi Keluhan</th>
                    <th>Gambar Keluhan</th>
                    <th>Status</th>
                    <th>Deskripsi Tindakan</th>
                    <th>Gambar Tindakan</th>
                    <th>Tanggal Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="9" class="no-data">Belum ada data monitoring untuk ditampilkan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data as $i => $d): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($d['username']) ?></td>
                        <td><?= htmlspecialchars($d['keluhan']) ?></td>
                        <td><?= nl2br(htmlspecialchars($d['deskripsi_keluhan'])) ?></td>
                        <td>
                            <?php if ($d['gambar_keluhan']): ?>
                                <img src="../../uploads/<?= htmlspecialchars($d['gambar_keluhan']) ?>" alt="Gambar Keluhan">
                            <?php else: ?>
                                Tidak ada
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                                $status_class = 'status-' . str_replace(' ', '_', strtolower($d['status']));
                            ?>
                            <span class="<?= htmlspecialchars($status_class) ?>"><?= htmlspecialchars(ucfirst($d['status'])) ?></span>
                        </td>
                        <td><?= nl2br(htmlspecialchars($d['deskripsi_tindakan'] ?? 'Belum ada tindakan')) ?></td>
                        <td>
                            <?php if ($d['gambar_tindakan']): ?>
                                <img src="../../uploads/tindakan/<?= htmlspecialchars($d['gambar_tindakan']) ?>" alt="Gambar Tindakan">
                            <?php else: ?>
                                Tidak ada
                            <?php endif; ?>
                        </td>
                        <td><?= $d['tanggal_tindakan'] ? htmlspecialchars(date('d M Y, H:i', strtotime($d['tanggal_tindakan']))) : 'Belum ada' ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>