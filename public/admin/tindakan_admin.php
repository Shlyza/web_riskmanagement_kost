<?php
require_once "../../config/session.php";
require_once "../../classes/Tindakan.php";

if (!isAdmin()) {
    die("Akses ditolak! Halaman ini hanya untuk admin.");
}

$tindakanModel = new Tindakan();
$keluhan_id = $_GET['keluhan_id'] ?? 0;
$list_tindakan = $tindakanModel->ambilSemua($keluhan_id);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deskripsi = $_POST['deskripsi'];
    $oleh = $_POST['oleh'];
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

    if ($tindakanModel->tambah($keluhan_id, $deskripsi, $oleh,$gambar)) {
        header("Location: tindakan_admin.php?keluhan_id=$keluhan_id");
        exit;
    } else {
        echo "Gagal menambah tindakan.";
    }
}
?>

<h2>Tambah Tindakan untuk Keluhan ID: <?= $keluhan_id ?></h2>
<form method="POST" action="" enctype="multipart/form-data">
    Deskripsi Tindakan:<br>
    <textarea name="deskripsi" required></textarea><br>
    Dilakukan Oleh:<br>
    <input type="text" name="oleh" required><br>
    Upload Gambar Tindakan:<br>
    <input type="file" name="gambar" accept="image/*"><br><br>
    <button type="submit">Simpan Tindakan</button>
</form>

<hr>
<h3>Daftar Tindakan:</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Deskripsi</th>
        <th>Tanggal</th>
        <th>Gambar</th>
        <th>Oleh</th>
    </tr>
    <?php foreach ($list_tindakan as $lt): ?>
        <tr>
            <td><?= $lt['id'] ?></td>
            <td><?= htmlspecialchars($lt['deskripsi']) ?></td>
            <td><?= $lt['tanggal_tindakan'] ?></td>
            <td>
                <?php if (!empty ($lt['gambar'])): ?>
                    <img src="../../uploads/tindakan/<?= htmlspecialchars($lt['gambar']) ?>" width="100">
                <?php else: ?>
                    Tidak ada
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($lt['dilakukan_oleh']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
