<?php

  session_start();
  require '../config/conexion.php';

  $id = $_GET['id'];
  
  echo $id;
 
  $sql = "DELETE FROM personas WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
  
  header("Location: ../views/admin/vendedores.php");

  $_SESSION['deleted'] = 1;
  
?>