<?php

require dirname(__DIR__) . '/config/admin_validation.php';
require dirname(__DIR__) . '/config/connection.php';

$id = $_GET['id'];

$sql = "UPDATE users SET is_active = false WHERE id = $1";
$result = pg_query_params($conn, $sql, array($id));

if ($result) {
    $_SESSION['deleted'] = 1;
}

pg_close($conn);

header("Location: ../views/admin/users.php");

?>