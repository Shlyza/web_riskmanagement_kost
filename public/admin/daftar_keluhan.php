<?php
require_once "../../config/session.php";
require_once "../../classes/Keluhan.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Akses ditolak!");
}

$keluhanModel = new Keluhan("", "", "", 0);
$daftar = $keluhanModel->ambilSemua();
?>

<a href="../dashboard.php">Home</a>
<h2>Daftar Semua Keluhan Penghuni</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama User</th>
        <th>Nama Keluhan</th>
        <th>Deskripsi</th>
        <th>Gambar</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($daftar as $k): ?>
    <tr>
        <td><?= $k['id'] ?></td>
        <td><?= htmlspecialchars($k['username']) ?></td>
        <td><?= htmlspecialchars($k['keluhan']) ?></td>
        <td><?= htmlspecialchars($k['deskripsi']) ?></td>
        <td>
        <?php if (!empty($k['gambar'])): ?>
        <img src="../../uploads/<?= htmlspecialchars($k['gambar']) ?>" width="150" alt="Gambar Keluhan" width="150">
        <?php else: ?>
            Tidak ada
        <?php endif; ?>

        </td>
        <td><?= $k['status'] ?? 'belum diproses' ?></td>
        <td>
            <a href="ubah_status.php?id=<?= $k['id'] ?>&status=proses">Proses</a> |
            <a href="ubah_status.php?id=<?= $k['id'] ?>&status=selesai">Selesai</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
