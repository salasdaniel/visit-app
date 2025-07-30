<?php
require '../config/admin_validation.php';
require '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = intval($_POST['product_id']);
    $product_name = trim($_POST['name']);
    $cost = floatval($_POST['cost_price']);
    $sale_price = floatval($_POST['sale_price']);
    $update_sql = "UPDATE products SET name = $1, cost_price = $2, sale_price = $3 WHERE id = $4";
    $update_result = pg_query_params($conn, $update_sql, array($product_name, $cost, $sale_price, $id));
    if ($update_result) {
        $_SESSION['msg'] = 'Product updated successfully!';
        $_SESSION['msg_code'] = 1;
        header("Location: ../views/admin/products.php");
        exit();
    } else {
        $_SESSION['msg'] = 'Error updating product: ' . pg_last_error($conn);
        $_SESSION['msg_code'] = 2;
        header("Location: ../views/admin/products.php");
        exit();
    }
}
