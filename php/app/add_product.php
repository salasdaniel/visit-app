<?php
require dirname(__DIR__) . '/config/admin_validation.php';
require dirname(__DIR__) . '/config/connection.php';

if (isset($_POST['submit'])) {
    // Get form data
    $name = trim($_POST['name']);
    $cost = floatval($_POST['cost_price']);
    $sale_price = floatval($_POST['sale_price']);
    $created_by_user_id = $_SESSION['user_id'];

    // Validate input (should be done in JS, but kept for security)
    if (empty($name)) {
        $_SESSION['msg'] = 'Product name is required.';
        $_SESSION['msg_code'] = 2;
        header('Location: ../views/admin/products.php');
        exit();
    }

    if ($cost < 0 || $sale_price < 0) {
        $_SESSION['msg'] = 'Prices cannot be negative.';
        $_SESSION['msg_code'] = 2;
        header('Location: ../views/admin/products.php');
        exit();
    }

    // Check if product already exists
    $check_sql = "SELECT id FROM products WHERE LOWER(name) = LOWER($1)";
    $check_result = pg_query_params($conn, $check_sql, array($name));

    if (pg_num_rows($check_result) > 0) {
        $_SESSION['msg'] = 'A product with this name already exists.';
        $_SESSION['msg_code'] = 2;
        header('Location: ../views/admin/products.php');
        exit();
    }
    // Insert new product
    $insert_sql = "INSERT INTO products (name, cost_price, sale_price, created_user) 
                   VALUES ($1, $2, $3, $4)";
    $insert_result = pg_query_params($conn, $insert_sql, array(
        $name,
        $cost,
        $sale_price,
        $created_by_user_id
    ));

    if ($insert_result) {
        $_SESSION['msg'] = 'Product registered successfully!';
        $_SESSION['msg_code'] = 1;
        header('Location: ../views/admin/products.php');
    } else {
        $_SESSION['msg'] = 'Error registering product: ' . pg_last_error($conn);
        $_SESSION['msg_code'] = 2;
        header('Location: ../views/admin/products.php');
    }
} else {
    $_SESSION['msg'] = 'Invalid request method.';
    $_SESSION['msg_code'] = 2;
    header('Location: ../views/admin/products.php');
}
exit();
