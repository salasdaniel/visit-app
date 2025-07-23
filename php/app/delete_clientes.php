<?php

  session_start();
  require '../config/conexion.php';

  $id = $_GET['id'];
 
  $sql = "DELETE FROM clientes WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
  
  header("Location: ../views/admin/clientes.php");

  $_SESSION['deleted'] = 1;
  
?>