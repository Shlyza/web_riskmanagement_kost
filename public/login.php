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
        echo "Login gagal. Coba lagi!";
    }
}
?>

<form method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit">Login</button>

    <p>Belum memiliki akun silahkan Registrasi <a href="registrasi.php">Registrasi</a></p>
</form>
