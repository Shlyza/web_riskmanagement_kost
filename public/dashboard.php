<?php
require_once "../config/session.php";
?>

<h2>Selamat datang, <?= $_SESSION['user']['username']; ?>!</h2>
<p>Role: <?= $_SESSION['user']['role']; ?></p>

<?php if (isAdmin()): ?>
    <P>Hallo Admin!</P>
    <a href="admin/tambah_penghuni.php">Tambah Penghuni</a><br>
    <a href="admin/edit_penghuni.php">Edit Penghuni</a><br>
    <a href="admin/hapus_penghuni.php">Hapus Penghuni</a><br>
    <a href="admin/daftar_keluhan.php">Daftar Keluhan</a>
<?php else: ?>
    <p>Halo Penghuni! Kamu hanya bisa melihat data kamu.</p>
    <a href="penghuni/form_penghuni.php">Isi Data</a>
    <a href="penghuni/data_penghuni.php">Profile</a>
    <a href="penghuni/keluhan_penghuni.php">Layanan Keluhan</a>
<?php endif; ?>

<a href="logout.php">Logout</a>
