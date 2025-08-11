<?php

session_start();
session_destroy();
header("Location: " . (($_SERVER['HTTP_HOST'] === 'localhost:8080') ? '/' : BASE_URL) . 'index.php');

?>