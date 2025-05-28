<?php
require_once "../../config/session.php";
require_once "../../classes/PenghuniKost.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Akses ditolak!");
}

$penghuniModel = new PenghuniKost(); // ✅ Aman
$data = $penghuniModel->ambilSemua();
?>

<h2>Daftar Penghuni Kost</h2>
<a href="../dashboard.php">Home</a><br>
<a href="../admin/daftar_monitoring.php">Daftar Monitoring</a><br>
<a href="../admin/daftar_keluhan.php">Daftar Keluhan</a><br>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Nomor Kamar</th>
        <th>Durasi Sewa</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($data as $p): ?>
    <tr>
        <td><?= htmlspecialchars($p['id']) ?></td>
        <td><?= htmlspecialchars($p['nama']) ?></td>
        <td><?= htmlspecialchars($p['nomor_kamar']) ?></td>
        <td><?= htmlspecialchars($p['durasi_sewa']) ?></td>
       <td>
            <a href="edit_penghuni.php?id=<?= $p['id'] ?>">Edit</a> |
            <a href="hapus_penghuni.php?id=<?= $p['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>

    </tr>
    <?php endforeach; ?>
</table>
