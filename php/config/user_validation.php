<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

if ($_SESSION['role'] != 2 ) {
    header("Location: ../../../index.php");
    exit;
}

?>