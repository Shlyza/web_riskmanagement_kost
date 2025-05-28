
<?php
require_once "../../config/session.php";
require_once "../../classes/Monitoring.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Akses ditolak!");
}

$monitoring = new Monitoring();
$data = $monitoring->ambilSemuaMonitoring();
?>

<h2>Monitoring Penanganan Keluhan</h2>

<a href="../dashboard.php">Home</a><br>
<a href="../admin/daftar_penghuni.php">Daftar Penghuni</a><br>
<a href="../admin/daftar_keluhan.php">Daftar Keluhan</a><br>
<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Penghuni</th>
        <th>Keluhan</th>
        <th>Deskripsi Keluhan</th>
        <th>Gambar Keluhan</th>
        <th>Status</th>
        <th>Tindakan</th>
        <th>Gambar Tindakan</th>
        <th>Tanggal Tindakan</th>
    </tr>

    <?php foreach ($data as $i => $d): ?>
    <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($d['username']) ?></td>
        <td><?= htmlspecialchars($d['keluhan']) ?></td>
        <td><?= htmlspecialchars($d['deskripsi_keluhan']) ?></td>
        <td>
            <?php if ($d['gambar_keluhan']): ?>
                <img src="../../uploads/<?= htmlspecialchars($d['gambar_keluhan']) ?>" width="100">
            <?php else: ?>
                Tidak ada
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($d['status']) ?></td>
        <td><?= htmlspecialchars($d['deskripsi_tindakan'] ?? 'Belum ada') ?></td>
        <td>
            <?php if ($d['gambar_tindakan']): ?>
                <img src="../../uploads/tindakan/<?= htmlspecialchars($d['gambar_tindakan']) ?>" width="100">
            <?php else: ?>
                Tidak ada
            <?php endif; ?>
        </td>
        <td><?= $d['tanggal_tindakan'] ?? 'Belum ada' ?></td>
    </tr>
    <?php endforeach; ?>
</table>
