<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

if ($_SESSION['role'] != 1 ) {

    header("Location: ../../../index.php");
    exit;
}

?>

