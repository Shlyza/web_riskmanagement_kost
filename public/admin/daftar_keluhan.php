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

<h2>Daftar Semua Keluhan Penghuni</h2>
<a href="../dashboard.php">Home</a><br>
<a href="../admin/daftar_penghuni.php">Daftar Penghuni</a><br>
<a href="../admin/daftar_monitoring.php">Daftar Monitoring</a><br>
<form method="get" action="">
    <label for="filter">Filter Risiko: </label>
    <select name="filter" id="filter">
        <option value="">Semua</option>
        <option value="tinggi">Tinggi (≥ 9)</option>
        <option value="sedang">Sedang (4-8)</option>
        <option value="rendah">Rendah (≤ 3)</option>
    </select>
    <button type="submit">Terapkan</button>
</form>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama User</th>
        <th>Nama Keluhan</th>
        <th>Deskripsi</th>
        <th>Gambar</th>
        <th>Status</th>
        <th>Aksi</th>
        <th>Monitoring</th>
        <th>Likelihood</th>
        <th>Impact</th>       
        <th>Level Resiko</th> 
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
        <td>
               <a href="tindakan_admin.php?keluhan_id=<?= $k['id'] ?>">Tindakan</a>
        </td>
        <td><?= htmlspecialchars($k['likelihood_keluhan']) ?></td>
        <td><?= htmlspecialchars($k['impact_keluhan']) ?></td>
         <td><?= htmlspecialchars($k['result_keluhan']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

