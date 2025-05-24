<?php
require_once "../../config/session.php";
require_once "../../classes/Keluhan.php";

if (!isPenghuni()) {
    die("Akses hanya untuk penghuni kost.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keluhan = $_POST['keluhan'];
    $deskripsi = $_POST['deskripsi'];
    $user_id = $_SESSION['user']['id'];
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $target_dir = "../../uploads/";
        $nama_file = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $nama_file;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($file_type, $allowed)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar = $nama_file; 
            } else {
                echo "Gagal upload gambar.";
            }
        } else {
            echo "File harus berupa gambar (jpg/png/gif).";
        }
    }

    $keluhan = new Keluhan($keluhan, $deskripsi, $gambar, $user_id);
    if ($keluhan->simpan()) {
        echo "Data keluhan berhasil disimpan!";
    } else{
        echo "Gagal menyimpan data";
    }
}
?>

<h2>Lapor Keluhan Lingkungan KOST</h2>
<form action="" method="post" enctype="multipart/form-data">
    Keluhan : <input type="text" name="keluhan" required><br>
    Deskripsi : <textarea  name="deskripsi"></textarea required><br>
    Gambar (opsional): <input type="file" name="gambar" accept="image/*"><br><br>
    <button type="submit">Simpan</button>
</form>