<?php
require_once "../classes/User.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; 

    if ($user->register($username, $password, $role)) {
        echo "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
    } else {
        echo "Registrasi gagal. Username mungkin sudah digunakan.";
    }
}
?>

<h2>Form Registrasi</h2>
<form method="post">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Role: 
    <select name="role">
        <option value="admin">Admin</option>
        <option value="penghuni">Penghuni Kost</option>
    </select><br>
    <button type="submit">Daftar</button>
</form>

<p><a href="login.php">Sudah punya akun? Login di sini</a></p>
