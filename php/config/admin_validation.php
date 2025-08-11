<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . (($_SERVER['HTTP_HOST'] === 'localhost:8080') ? '/php/views/' : BASE_URL . 'php/views/') . 'login.php');
    exit();
}

if ($_SESSION['role'] != 1 ) {

    header("Location: " . (($_SERVER['HTTP_HOST'] === 'localhost:8080') ? '/' : BASE_URL) . 'index.php');
    exit;
}

