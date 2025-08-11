<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Advanced Contact Form with File Uploader">
    <meta name="author" content="UWS">
    <title>Visit - APP </title>

    <?php
    // Include configuration if not already included
    if (!defined('BASE_URL')) {
        require_once(dirname(__DIR__) . '/config/connection.php');
    }
    
    // For Docker environment, use root path
    $base_path = $_SERVER['HTTP_HOST'] === 'localhost:8080' ? '/' : BASE_URL;
    ?>

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- References with absolute paths -->
    <link href="<?php echo $base_path; ?>img/favicon.png" rel="shortcut icon">
    <link href="<?php echo $base_path; ?>vendor/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>vendor/icomoon/css/iconfont.min.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>vendor/dmenu/css/menu.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>vendor/hamburgers/css/hamburgers.min.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>vendor/mmenu/css/mmenu.min.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>vendor/filepond/css/filepond.css" rel="stylesheet">
    <link href="<?php echo $base_path; ?>css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="../../../vendor/jquery/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    


</head>

<body>


    <!-- Preloader -->
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>
    <!-- Preloader End -->

    <!-- Page -->
    <div id="page">
     