<?php
require '../config/admin_validation.php';
require '../config/connection.php';

$id = $_POST['id'];
$first_name = trim(strtoupper($_POST['first_name']));
$last_name = trim(strtoupper($_POST['last_name']));
$ruc = trim($_POST['tax_id']);
$phone = trim($_POST['phone']);
$address = strtolower($_POST['address']);
$visit_day = trim(strtoupper($_POST['visit_day']));
$visit_time = $_POST['visit_time'];
$observation = strtolower($_POST['notes']);

$sql = "UPDATE customers
            SET first_name = $1, last_name = $2, tax_id = $3, phone = $4, address = $5, visit_day = $6, visit_time = $7, notes = $8
            WHERE id = $9";
$params = array($first_name, $last_name, $ruc, $phone, $address, $visit_day, $visit_time, $observation, $id);
$result = pg_query_params($conn, $sql, $params);

if ($result) {
    $_SESSION['msg'] = "Client data has been updated successfully.";
    $_SESSION['msg_code'] = 1;
    header("Location: ../views/admin/clients.php");
    exit;
} else {
    $_SESSION['msg'] = "Error communicating with the database!";
    $_SESSION['msg_code'] = 2;
    header("Location: ../views/admin/clients.php");
    exit;
}

pg_close($conn);

?>
