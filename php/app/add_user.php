<?php

    require '../config/admin_validation.php';
    require '../config/connection.php';

    $first_name = trim(strtoupper($_POST['first_name']));
    $last_name = trim(strtoupper($_POST['last_name']));
    $document = trim($_POST['document_number']);
    $role = trim($_POST['role']);

    // Check if document already exists
    $sql_check = "SELECT * FROM users WHERE document_number = $1";
    $result_check = pg_query_params($conn, $sql_check, array($document));

    if (pg_num_rows($result_check) > 0) {
        $_SESSION['msg'] = "The entered document is already registered in the database.";
        $_SESSION['msg_code'] = 0;
        header("Location: ../views/admin/users.php");
        exit;
    } else {
        $sql_insert = "INSERT INTO users (first_name, last_name, document_number, role, is_active) VALUES ($1, $2, $3, $4, true)";
        $result_insert = pg_query_params($conn, $sql_insert, array($first_name, $last_name, $document, $role));

        if ($result_insert) {
            $_SESSION['msg'] = "A new user has been registered in the database.";
            $_SESSION['msg_code'] = 1;
            header("Location: ../views/admin/users.php");
            exit;
        } else {
            $_SESSION['msg'] = "Error communicating with the database!";
            $_SESSION['msg_code'] = 2;
            header("Location: ../views/admin/users.php");
            exit;
        }
    }

    pg_free_result($result_check);
    pg_close($conn);

?>
