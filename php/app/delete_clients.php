<?php
require dirname(__DIR__) . '/config/admin_validation.php';
require dirname(__DIR__) . '/config/connection.php';

$id = $_GET['id'];
$sql = "UPDATE customers SET is_active = false WHERE id = $1";
$result = pg_query_params($conn, $sql, array($id));
pg_close($conn);

$_SESSION['deleted'] = 1;
header("Location: ../views/admin/clients.php");
?>