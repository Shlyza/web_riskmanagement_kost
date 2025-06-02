<?php
require_once "../classes/User.php";

$registration_message = ''; // Variabel untuk menyimpan pesan registrasi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($user->register($username, $password, $role)) {
        $registration_message = "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
    } else {
        $registration_message = "Registrasi gagal. Username mungkin sudah digunakan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 320px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
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
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
        }
        .message.success {
            background-color: #e6fffa;
            color: #007a5e;
            border: 1px solid #b3fff0;
        }
        .message.error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        p {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Registrasi</h2>
        <?php if (!empty($registration_message)): ?>
            <div class="message <?php echo (strpos($registration_message, 'berhasil') !== false) ? 'success' : 'error'; ?>">
                <?php echo $registration_message; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="role">Role:</label>
                <select name="role" id="role">
                    <option value="admin">Admin</option>
                    <option value="penghuni" selected>Penghuni Kost</option>
                </select>
            </div>
            <button type="submit">Daftar</button>
        </form>
        <p><a href="login.php">Sudah punya akun? Login di sini</a></p>
    </div>
</body>
</html>