<?php 
session_start();

if ($_SESSION['rol'] != 2 ) {

    header("Location: ../../../index.php");
    exit;

}

?>