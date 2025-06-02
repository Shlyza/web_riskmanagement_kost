<?php
require_once "../../config/session.php";
require_once "../../classes/Keluhan.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Akses ditolak!");
}

$keluhanModel = new Keluhan("", "", "",0,0,0);
$daftar = $keluhanModel->ambilSemua();

$filter = $_GET['filter'] ?? '';
$keluhanModel = new Keluhan("", "", "",0,0,0);

if ($filter) {
    $daftar = $keluhanModel->ambilDenganFilterRisiko($filter);
} else {
    $daftar = $keluhanModel->ambilSemua();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Keluhan Penghuni</title>
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
            max-width: 1300px; /* Max width disesuaikan */
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
            margin-bottom: 20px; /* Disesuaikan jaraknya */
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
             /* justify-content: center; Dihapus agar default ke kiri */
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
        .filter-form {
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
            align-items: center;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 6px;
        }
        .filter-form label {
            font-weight: bold;
            color: #555;
        }
        .filter-form select {
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 150px;
        }
        .filter-form button {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .filter-form button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px; /* Disesuaikan jaraknya */
            font-size: 0.9em; /* Sedikit perkecil font jika kolom banyak */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px; 
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            white-space: nowrap; 
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
            display: block;
        }
        .action-links a, .monitoring-link a {
            text-decoration: none;
            padding: 5px 10px;
            margin-right: 5px;
            border-radius: 4px;
            font-size: 0.9em;
            color: white;
            display: inline-block; /* Agar rapi */
            margin-bottom: 3px; /* Jarak jika ada 2 link */
        }
        .action-links .proses-link { background-color: #ffc107; color: #333; }
        .action-links .proses-link:hover { background-color: #e0a800; }
        .action-links .selesai-link { background-color: #28a745; }
        .action-links .selesai-link:hover { background-color: #218838; }
        .monitoring-link a { background-color: #17a2b8; }
        .monitoring-link a:hover { background-color: #138496; }

        .status-belum_diproses { background-color: #ffebee; color: #c62828; padding: 5px 8px; border-radius: 4px; font-weight: bold; }
        .status-proses { background-color: #fff9c4; color: #f57f17; padding: 5px 8px; border-radius: 4px; font-weight: bold; }
        .status-selesai { background-color: #e8f5e9; color: #2e7d32; padding: 5px 8px; border-radius: 4px; font-weight: bold; }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
        }
        .risk-level-tinggi { background-color: #dc3545; color: white; padding: 3px 6px; border-radius: 3px; font-size:0.9em; }
        .risk-level-sedang { background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size:0.9em;}
        .risk-level-rendah { background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size:0.9em;}

    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Semua Keluhan Penghuni</h2>

        <div class="navigation-links">
            <a href="../dashboard.php">Home</a>
            <a href="../admin/daftar_penghuni.php">Daftar Penghuni</a>
            <a href="../admin/daftar_monitoring.php">Daftar Monitoring</a>
        </div>

        <form method="get" action="" class="filter-form">
            <label for="filter">Filter Risiko: </label>
            <select name="filter" id="filter">
                <option value="" <?= ($filter == '') ? 'selected' : '' ?>>Semua</option>
                <option value="tinggi" <?= ($filter == 'tinggi') ? 'selected' : '' ?>>Tinggi (≥ 9)</option>
                <option value="sedang" <?= ($filter == 'sedang') ? 'selected' : '' ?>>Sedang (4-8)</option>
                <option value="rendah" <?= ($filter == 'rendah') ? 'selected' : '' ?>>Rendah (≤ 3)</option>
            </select>
            <button type="submit">Terapkan</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama User</th>
                    <th>Nama Keluhan</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <th>Likelihood</th>
                    <th>Impact</th>       
                    <th>Level Risiko</th> 
                    <th>Aksi Status</th>
                    <th>Tindakan Lanjut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftar)): ?>
                    <tr>
                        <td colspan="11" class="no-data">Tidak ada data keluhan yang sesuai dengan filter atau belum ada keluhan sama sekali.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftar as $k): ?>
                    <tr>
                        <td><?= $k['id'] ?></td>
                        <td><?= htmlspecialchars($k['username']) ?></td>
                        <td><?= htmlspecialchars($k['keluhan']) ?></td>
                        <td><?= nl2br(htmlspecialchars($k['deskripsi'])) ?></td>
                        <td>
                        <?php if (!empty($k['gambar'])): ?>
                            <img src="../../uploads/<?= htmlspecialchars($k['gambar']) ?>" alt="Gambar Keluhan">
                        <?php else: ?>
                            Tidak ada
                        <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                                $status_text = strtolower($k['status'] ?? 'belum diproses');
                                $status_class_processed = str_replace(' ', '_', $status_text);
                            ?>
                            <span class="status-<?= htmlspecialchars($status_class_processed) ?>"><?= htmlspecialchars(ucfirst($status_text)) ?></span>
                        </td>
                        <td><?= htmlspecialchars($k['likelihood_keluhan']) ?></td>
                        <td><?= htmlspecialchars($k['impact_keluhan']) ?></td>
                        <td>
                            <?php
                                $result_keluhan = $k['result_keluhan'];
                                $level_risiko_text = '';
                                $level_risiko_class = '';
                                if ($result_keluhan >= 9) {
                                    $level_risiko_text = 'Tinggi';
                                    $level_risiko_class = 'risk-level-tinggi';
                                } elseif ($result_keluhan >= 4 && $result_keluhan < 9) {
                                    $level_risiko_text = 'Sedang';
                                    $level_risiko_class = 'risk-level-sedang';
                                } elseif ($result_keluhan < 4 && $result_keluhan > 0) { // result_keluhan > 0 untuk menangani jika L atau I adalah 0
                                    $level_risiko_text = 'Rendah';
                                    $level_risiko_class = 'risk-level-rendah';
                                } else {
                                    $level_risiko_text = 'N/A'; // Jika L atau I belum diisi atau 0
                                }
                            ?>
                            <span class="<?= $level_risiko_class ?>"><?= htmlspecialchars($level_risiko_text) ?></span>
                            (<?= htmlspecialchars($result_keluhan) ?>)
                        </td>
                        <td class="action-links">
                            <a href="ubah_status.php?id=<?= $k['id'] ?>&status=proses" class="proses-link">Proses</a>
                            <a href="ubah_status.php?id=<?= $k['id'] ?>&status=selesai" class="selesai-link">Selesai</a>
                        </td>
                        <td class="monitoring-link">
                               <a href="tindakan_admin.php?keluhan_id=<?= $k['id'] ?>">Tindakan</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>