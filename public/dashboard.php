<?php
require_once "../config/session.php"; //
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .dashboard-container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 15px;
            font-size: 28px;
            color: #007bff;
        }
        .role-info {
            text-align: center;
            margin-bottom: 30px;
            font-size: 18px;
            color: #555;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
        }
        .navigation-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff; 
        }
        .menu-title {
            font-size: 22px;
            color: #343a40;
            margin-bottom: 5px; 
        }
        .info-text-navigation {
            font-size: 16px;
            color: #6c757d;
            margin-top: 5px; 
            margin-bottom: 10px; 
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .menu-card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: flex-start; /* Konten dimulai dari atas, lalu flex-grow bisa digunakan jika perlu */
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .menu-card .card-text { /* Styling untuk teks di dalam card */
            font-size: 18px;
            font-weight: 500;
            color: #007bff; 
            margin-bottom: 15px; /* Jarak antara teks dan gambar */
        }
         .menu-card:hover .card-text { 
            color: #0056b3;
        }
        .menu-card img.card-illustration { 
            width: 37px; 
            height: 37px; 
            object-fit: contain; 
            margin-top: auto; 
        }
        .logout-link {
            display: block;
            width: fit-content;
            margin: 30px auto 0 auto;
            padding: 12px 25px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .logout-link:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2 class="welcome-message">Selamat datang, <?= htmlspecialchars($_SESSION['user']['username']); ?>!</h2>
        <p class="role-info">Role Anda: <strong><?= htmlspecialchars($_SESSION['user']['role']); ?></strong></p>

        <div class="navigation-header">
            <h3 class="menu-title">Menu Navigasi</h3>
            <?php if (isAdmin()): ?>
                <p class="info-text-navigation">Halo Admin! Kelola sistem dari menu di bawah ini.</p>
            <?php else: ?>
                <p class="info-text-navigation">Halo Penghuni! Akses fitur Anda melalui menu berikut.</p>
            <?php endif; ?>
        </div>

        <div class="menu-grid">
            <?php if (isAdmin()): ?>
                <a href="admin/daftar_penghuni.php" class="menu-card">
                    <span class="card-text">Daftar Penghuni</span>
                    <img src="images/people.png" alt="Daftar Penghuni" class="card-illustration">
                </a>
                <a href="admin/daftar_keluhan.php" class="menu-card">
                    <span class="card-text">Daftar Keluhan</span>
                    <img src="images/clipboard.png" alt="Daftar Keluhan" class="card-illustration">
                </a>
                <a href="admin/daftar_monitoring.php" class="menu-card">
                    <span class="card-text">Daftar Monitoring</span>
                    <img src="images/watch.png" alt="Daftar Monitoring" class="card-illustration">
                </a>
            <?php else: ?>
                <a href="penghuni/form_penghuni.php" class="menu-card">
                    <span class="card-text">Isi/Perbarui Data Diri</span>
                    <img src="images/pen.png" alt="Isi Data Diri" class="card-illustration">
                </a>
                <a href="penghuni/data_penghuni.php" class="menu-card">
                    <span class="card-text">Profil Saya</span>
                    <img src="images/user.png" alt="Profil Saya" class="card-illustration">
                </a>
                <a href="penghuni/keluhan_penghuni.php" class="menu-card">
                    <span class="card-text">Layanan Keluhan</span>
                    <img src="images/tandaseru.png" alt="Layanan Keluhan" class="card-illustration">
                </a>
            <?php endif; ?>
        </div>

        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html>