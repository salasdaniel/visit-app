<?php
session_start();
require '../config/conexion.php';

$id = $_GET['id'];
$sql = "UPDATE clientes SET activo = false WHERE id = $1";
$result = pg_query_params($conn, $sql, array($id));
pg_close($conn);

$_SESSION['deleted'] = 1;
header("Location: ../views/admin/clients.php");
?>