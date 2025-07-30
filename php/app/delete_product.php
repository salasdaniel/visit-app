<?php
require '../config/admin_validation.php';
require '../config/connection.php';
// Check if user is logged in

$id = $_GET['id'];
$delete_sql = "UPDATE products SET is_active = false WHERE id = $1";
$delete_result = pg_query_params($conn, $delete_sql, array($id));

if ($delete_result) {
    $_SESSION['deleted'] = 1;
} else {
    $_SESSION['msg'] = 'Error inactivating product: ' . pg_last_error($conn);
    $_SESSION['msg_code'] = 2;
}


header('Location: ../views/admin/products.php');
exit();
