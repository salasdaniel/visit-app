<?php

require '../config/admin_validation.php';
require '../config/connection.php';

$first_name = trim(strtoupper($_POST['first_name']));
$last_name = trim(strtoupper($_POST['last_name']));
$ruc = trim($_POST['tax_id']);
$phone = trim($_POST['phone']);
$address = strtolower($_POST['address']);
$plan = trim(strtoupper($_POST['subscription_plan']));
$observation = strtolower($_POST['notes']);

// Check if client already exists
$sql_check = "SELECT * FROM customers WHERE tax_id = $1";
$result_check = pg_query_params($conn, $sql_check, array($ruc));

if (pg_num_rows($result_check) > 0) {
    $_SESSION['msg'] = "The entered document is already registered in the database.";
    $_SESSION['msg_code'] = 0;
    header("Location: ../views/admin/clients.php");
    exit();
}

// Insert new client (id is auto-generated)
$sql_insert = "INSERT INTO customers (first_name, last_name, tax_id, phone, address, subscription_plan, notes) VALUES ($1, $2, $3, $4, $5, $6, $7)";
$params = array($first_name, $last_name, $ruc, $phone, $address, $plan, $observation);
$result_insert = pg_query_params($conn, $sql_insert, $params);

if ($result_insert) {
    $_SESSION['msg'] = "A new client has been registered in the database.";
    $_SESSION['msg_code'] = 1;
    if ($_SESSION['role'] == 1) {
        header("Location: ../views/admin/clients.php");
    } else {
        header("Location: ../views/user/seller_view.php");
    }
    exit();
} else {
    $_SESSION['msg'] = "Error communicating with the database!";
    $_SESSION['msg_code'] = 2;
    header("Location: ../views/admin/clients.php");
    exit();
}
?>
