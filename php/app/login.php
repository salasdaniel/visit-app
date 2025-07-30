<?php

require '../config/connection.php';

if (isset($_POST['document'])) {

    $document_number = $_POST['document'];
    $sql = "SELECT * FROM users WHERE document_number = $1";
    $result = pg_query_params($conn, $sql, array($document_number));

    if ($result && pg_num_rows($result) > 0) {

        session_start();

        $user_info = pg_fetch_assoc($result);
        $user_id = $user_info['id'];
        $first_name = $user_info['first_name'];
        $last_name = $user_info['last_name'];
        $document = $user_info['document_number'];
        $role = $user_info['role'];

        $_SESSION['user_id'] = $user_id;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['document'] = $document;
        $_SESSION['role'] = $role;

        pg_free_result($result);
        pg_close($conn);

        if ($role == 1) {
            // header('location:../views/admin/admin.php');
            header('location: ../views/admin/admin.php');
            exit;
        } else {
            // print_r($_SESSION);
            header('location: ../views/user/entry.php');
            exit;
        }

    } else {
        session_start();
        $_SESSION['error'] = 0;
        pg_close($conn);
        header('location: ../../index.php');
    }
}
