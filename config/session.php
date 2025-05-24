<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

function isAdmin() {
    return $_SESSION['user']['role'] === 'admin';
}

function isPenghuni() {
    return $_SESSION['user']['role'] === 'penghuni';
}
?>
