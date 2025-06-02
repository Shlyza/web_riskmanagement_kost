<?php
require_once "../../config/session.php";
require_once "../../classes/Keluhan.php";

if (!isPenghuni()) {
    die("Akses hanya untuk penghuni kost.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keluhan = $_POST['keluhan'];
    $deskripsi = $_POST['deskripsi'];
    $likelihood = (int)$_POST['likelihood'];
    $impact = (int)$_POST['impact'];
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

    $keluhan = new Keluhan($keluhan, $deskripsi, $gambar, $user_id, $likelihood, $impact);
    if ($keluhan->simpan()) {
        echo "Data keluhan berhasil disimpan!";
    } else{
        echo "Gagal menyimpan data";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Keluhan Lingkungan KOST</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        input[type="file"] {
            padding: 8px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-hint {
            font-size: 0.9em;
            color: #777;
            display: block;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-bottom: 20px; 
            padding: 12px;
            border-radius: 4px;
            font-size: 1.0em;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .navigation-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .navigation-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lapor Keluhan Lingkungan KOST</h2> <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data"> <div class="input-group">
                <label for="keluhan">Judul Keluhan:</label>
                <input type="text" id="keluhan" name="keluhan" required> </div>
            
            <div class="input-group">
                <label for="deskripsi">Deskripsi Keluhan:</label>
                <textarea id="deskripsi" name="deskripsi"></textarea> </div>

            <div class="input-group">
                <label for="likelihood">Likelihood (Nilai Kemungkinan Terjadi):</label>
                <input type="number" id="likelihood" name="likelihood" min="1" max="5" required> <span class="input-hint">Skala 1 (Sangat Jarang) hingga 5 (Sangat Sering).</span>
            </div>

            <div class="input-group">
                <label for="impact">Impact (Nilai Dampak Jika Terjadi):</label>
                <input type="number" id="impact" name="impact" min="1" max="5" required> <span class="input-hint">Skala 1 (Sangat Ringan) hingga 5 (Sangat Berat).</span>
            </div>

            <div class="input-group">
                <label for="gambar">Gambar (Opsional):</label>
                <input type="file" id="gambar" name="gambar" accept="image/*"> </div>
            
            <button type="submit">Simpan Keluhan</button> </form>

        <a href="../dashboard.php" class="navigation-link">Kembali ke Dashboard</a>
    </div>
</body>
</html>