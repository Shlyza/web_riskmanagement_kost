<?php
require_once "Database.php";

class User extends Database {
    public function login($username, $password) {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, md5($password)); // md5 untuk mencocokkan
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            session_start();
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            return true;
        }
        return false;
    }

    public function register($username, $password, $role) {
    $conn = $this->getConnection();
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $hashed = md5($password); // Untuk real use, ganti ke password_hash
    $stmt->bind_param("sss", $username, $hashed, $role);
    return $stmt->execute();
}


    public function logout() {
        session_start();
        session_destroy();
    }
}
?>
