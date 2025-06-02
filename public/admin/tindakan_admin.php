<?php
require_once "../../config/session.php";
require_once "../../classes/Tindakan.php";

if (!isAdmin()) {
    die("Akses ditolak! Halaman ini hanya untuk admin.");
}

$tindakanModel = new Tindakan();
$keluhan_id = $_GET['keluhan_id'] ?? 0;

// gunakan setter untuk mengisi nilai keluhan_id
$tindakanModel->setKeluhanId($keluhan_id);

// lalu panggil method ambilSemua() tanpa parameter
$list_tindakan = $tindakanModel->ambilSemua();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deskripsi = $_POST['deskripsi'];
    $oleh = $_POST['oleh'];
    $tindakanModel->setLikelihood((int)$_POST['likelihood']);
    $tindakanModel->setImpact((int)$_POST['impact']);
// Tidak perlu setResult lagi

    $gambar = null;

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $target_dir = "../../uploads/tindakan/";
        $nama_file = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $nama_file;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($file_type, $allowed)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar = $nama_file;
            } else {
                echo "Gagal upload gambar tindakan.";
            }
        } else {
            echo "File tidak valid (jpg/png/gif).";
        }
    }

    $tindakanModel->setKeluhanId($keluhan_id);
    $tindakanModel->setDeskripsi($deskripsi);
    $tindakanModel->setOleh($oleh);
    $tindakanModel->setGambar($gambar);

    if ($tindakanModel->tambah()) {
        header("Location: tindakan_admin.php?keluhan_id=$keluhan_id");
        exit;
    } else {
        echo "Gagal menambah tindakan.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tindakan untuk Keluhan ID: <?= htmlspecialchars($keluhan_id) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .main-container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2, h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .navigation-links {
            margin-bottom: 20px;
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

        .form-container, .list-container {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background-color: #fdfdfd;
        }

        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }
        .form-group input[type="file"] {
            padding: 5px;
        }
        .input-hint {
            font-size: 0.85em;
            color: #777;
            display: block;
            margin-top: 3px;
        }

        .form-buttons button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .form-buttons button:hover {
            background-color: #218838;
        }

        .message {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 1.0em;
            border-width: 1px;
            border-style: solid;
        }
        .message.success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .message.error { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 0.9em;
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
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f1f1; }
        td img { max-width: 80px; height: auto; border-radius: 4px; display: block; }
        .no-data { text-align: center; padding: 15px; color: #777; }
         .risk-level-tinggi { background-color: #dc3545; color: white; padding: 3px 6px; border-radius: 3px; font-size:0.9em; }
        .risk-level-sedang { background-color: #ffc107; color: #212529; padding: 3px 6px; border-radius: 3px; font-size:0.9em;}
        .risk-level-rendah { background-color: #28a745; color: white; padding: 3px 6px; border-radius: 3px; font-size:0.9em;}
    </style>
</head>
<body>
    <div class="main-container">
        <div class="navigation-links">
            <a href="../dashboard.php">Home</a>
            <a href="daftar_keluhan.php">Kembali ke Daftar Keluhan</a>
        </div>

        <h2>Manajemen Tindakan untuk Keluhan ID: <?= htmlspecialchars($keluhan_id) ?></h2>

        <?php if (!empty($message)): ?>
            <div class="message <?= htmlspecialchars($message_type); ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h3>Form Tambah Tindakan</h3>
            <form method="POST" action="tindakan_admin.php?keluhan_id=<?= htmlspecialchars($keluhan_id) ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Tindakan:</label>
                    <textarea id="deskripsi" name="deskripsi" required><?= htmlspecialchars($_POST['deskripsi'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label for="oleh">Dilakukan Oleh:</label>
                    <input type="text" id="oleh" name="oleh" value="<?= htmlspecialchars($_POST['oleh'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="likelihood">Likelihood Tindakan (Setelah Tindakan):</label>
                    <input type="number" id="likelihood" name="likelihood" min="1" max="5" value="<?= htmlspecialchars($_POST['likelihood'] ?? '') ?>" required>
                    <span class="input-hint">Skala 1 (Sangat Jarang) hingga 5 (Sangat Sering).</span>
                </div>
                <div class="form-group">
                    <label for="impact">Impact Tindakan (Setelah Tindakan):</label>
                    <input type="number" id="impact" name="impact" min="1" max="5" value="<?= htmlspecialchars($_POST['impact'] ?? '') ?>" required>
                    <span class="input-hint">Skala 1 (Sangat Ringan) hingga 5 (Sangat Berat).</span>
                </div>
                <div class="form-group">
                    <label for="gambar">Upload Gambar Tindakan (Opsional, Max 2MB):</label>
                    <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/gif">
                </div>
                <div class="form-buttons">
                    <button type="submit">Simpan Tindakan</button>
                </div>
            </form>
        </div>

        <hr>

        <div class="list-container">
            <h3>Daftar Tindakan yang Telah Dilakukan:</h3>
            <?php if (empty($list_tindakan)): ?>
                <p class="no-data">Belum ada tindakan yang dicatat untuk keluhan ini.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th>Gambar</th>
                            <th>Oleh</th>
                            <th>Likelihood</th>
                            <th>Impact</th>
                            <th>Level Risiko Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_tindakan as $lt): ?>
                            <tr>
                                <td><?= $lt['id'] ?></td>
                                <td><?= nl2br(htmlspecialchars($lt['deskripsi'])) ?></td>
                                <td><?= htmlspecialchars(date('d M Y, H:i', strtotime($lt['tanggal_tindakan']))) ?></td>
                                <td>
                                    <?php if (!empty($lt['gambar'])): ?>
                                        <img src="../../uploads/tindakan/<?= htmlspecialchars($lt['gambar']) ?>" alt="Gambar Tindakan">
                                    <?php else: ?>
                                        Tidak ada
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($lt['dilakukan_oleh']) ?></td>
                                <td><?= htmlspecialchars($lt['likelihood_tindakan']) ?></td>
                                <td><?= htmlspecialchars($lt['impact_tindakan']) ?></td>
                                 <td>
                                    <?php
                                        $result_tindakan = $lt['result_tindakan'];
                                        $level_risiko_text = '';
                                        $level_risiko_class = '';
                                        if ($result_tindakan >= 9) {
                                            $level_risiko_text = 'Tinggi';
                                            $level_risiko_class = 'risk-level-tinggi';
                                        } elseif ($result_tindakan >= 4 && $result_tindakan < 9) {
                                            $level_risiko_text = 'Sedang';
                                            $level_risiko_class = 'risk-level-sedang';
                                        } elseif ($result_tindakan < 4 && $result_tindakan > 0 ) {
                                            $level_risiko_text = 'Rendah';
                                            $level_risiko_class = 'risk-level-rendah';
                                        } else {
                                            $level_risiko_text = 'N/A';
                                        }
                                    ?>
                                    <span class="<?= $level_risiko_class ?>"><?= htmlspecialchars($level_risiko_text) ?></span>
                                    (<?= htmlspecialchars($result_tindakan) ?>)
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>