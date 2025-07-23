<?php

require '../config/conexion.php';

if (isset($_POST['ci'])) {


    $ci_ingreso = $_POST['ci'];
    $sql = "SELECT * FROM personas WHERE ci = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ci_ingreso);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        session_start();

        $info_usuario = $result->fetch_assoc();
        $id = $info_usuario['id'];
        $nombre = $info_usuario['nombre'];
        $apellido = $info_usuario['apellido'];
        $ci = $info_usuario['ci'];
        $rol = $info_usuario['rol'];

        $_SESSION['id'] = $id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['ci'] = $ci;
        $_SESSION['rol'] = $rol;


        if ($rol == 1) {

            $stmt->close();
            $conn->close();
            header('location:../views/admin/admin.php');
            
        } elseif ($rol == 2) {

            $stmt->close();
            $conn->close();
            echo '<script>window.location.href = "../views/user/qr.php";</script>';
        }

        $stmt->close();
        $conn->close();
    } else {

        session_start();
        $_SESSION['error'] = 0;
        header('location: ../../index.php');
    }
}
