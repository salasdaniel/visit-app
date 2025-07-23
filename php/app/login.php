<?php

require '../config/conexion.php';

if (isset($_POST['ci'])) {

    $document_number = $_POST['ci'];
    $sql = "SELECT * FROM personas WHERE ci = $1";
    $result = pg_query_params($conn, $sql, array($document_number));

    if ($result && pg_num_rows($result) > 0) {

        session_start();

        $user_info = pg_fetch_assoc($result);
        $user_id = $user_info['id'];
        $first_name = $user_info['nombre'];
        $last_name = $user_info['apellido'];
        $document = $user_info['ci'];
        $role = $user_info['rol'];

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
        } elseif ($role == 2) {
            echo '<script>window.location.href = "../views/user/qr.php";</script>';
            exit;
        }

    } else {
        session_start();
        $_SESSION['error'] = 0;
        pg_close($conn);
        header('location: ../../index.php');
    }
}
