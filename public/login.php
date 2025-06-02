<?php
require_once "../classes/User.php"; 
session_start(); 
if (isset($_SESSION['user'])) { 
    header("Location: dashboard.php"); 
    exit; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $user = new User(); 
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    if ($user->login($username, $password)) { 
        header("Location: dashboard.php"); 
        exit; 
    } else {
        $login_error = "Login gagal. Username atau password salah!"; 
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        input[type="password"] {
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
        .error-message {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            border-radius: 4px;
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
        <h2>Login</h2>
        <?php if (!empty($login_error)): ?>
            <div class="error-message">
                <?php echo $login_error; ?>
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
            <button type="submit">Login</button>
        </form>
        <p>Belum memiliki akun? <a href="registrasi.php">Registrasi di sini</a></p>
    </div>
</body>
</html>