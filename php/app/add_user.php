<?php

    session_start();
    require '../config/conexion.php';

    $first_name = trim(strtoupper($_POST['nombre']));
    $last_name = trim(strtoupper($_POST['apellido']));
    $document = trim($_POST['ci']);
    $role = trim($_POST['rol']);

    // Check if document already exists
    $sql_check = "SELECT * FROM personas WHERE ci = $1";
    $result_check = pg_query_params($conn, $sql_check, array($document));

    if (pg_num_rows($result_check) > 0) {
        $_SESSION['msg'] = "The entered document is already registered in the database.";
        $_SESSION['msg_code'] = 0;
        header("Location: ../views/admin/users.php");
        exit;
    } else {
        $sql_insert = "INSERT INTO personas (nombre, apellido, ci, rol, activo) VALUES ($1, $2, $3, $4, true)";
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
