<?php
require_once "../../config/session.php"; 
require_once "../../classes/Database.php"; 

if (!isPenghuni()) { 
    die("Akses hanya untuk penghuni."); 
}

$db = new Database(); 
$conn = $db->getConnection(); 

$user_id = $_SESSION['user']['id']; 
$sql = "SELECT * FROM penghuni WHERE user_id = ?"; 
$stmt = $conn->prepare($sql); 
$stmt->bind_param("i", $user_id); 
$stmt->execute(); 
$result = $stmt->get_result(); 
$data = $result->fetch_assoc(); 

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penghuni Saya</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin-top: 30px; /* Add some margin at the top */
        }
        h3 {
            text-align: center;
            color: #007bff;
            margin-bottom: 25px;
            font-size: 24px;
        }
        .data-item {
            margin-bottom: 15px;
            font-size: 18px;
            line-height: 1.6;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .data-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .data-label {
            font-weight: bold;
            color: #333;
        }
        .data-value {
            color: #555;
        }
        .no-data-message {
            text-align: center;
            font-size: 18px;
            color: #777;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px dashed #ddd;
            border-radius: 4px;
        }
        .navigation-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            padding: 10px 15px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .navigation-link:hover {
            background-color: #5a6268;
        }
        .edit-link {
             display: inline-block;
             margin-left: 10px;
             font-size: 0.9em;
             color: #007bff;
        }
        .edit-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($data) { //
            echo "<h3>Data Penghuni Kamu</h3>"; //
            echo "<div class='data-item'><span class='data-label'>Nama:</span> <span class='data-value'>" . htmlspecialchars($data['nama']) . "</span></div>"; //
            echo "<div class='data-item'><span class='data-label'>Nomor Kamar:</span> <span class='data-value'>" . htmlspecialchars($data['nomor_kamar']) . "</span></div>"; //
            echo "<div class='data-item'><span class='data-label'>Durasi Sewa:</span> <span class='data-value'>" . htmlspecialchars($data['durasi_sewa']) . "</span></div>"; //
        } else {
            echo "<div class='no-data-message'>Kamu belum mengisi data kost. <br><a href='form_penghuni.php' class='edit-link'>Isi Data Sekarang</a></div>"; //
        }
        ?>
        <a href="../dashboard.php" class="navigation-link">Kembali ke Dashboard</a>
    </div>
</body>
</html>