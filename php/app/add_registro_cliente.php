<?php

    session_start();
    require '../config/conexion.php';

    if (!$_SESSION['id'] && !$_SESSION['nombre']) {

        header("Location: index.php");
        exit;
    }

    $id_cliente = $_POST['id_cliente'];

    $sql = "SELECT * FROM clientes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();

    $info_usuario = $result->fetch_assoc();

    $_SESSION['id_cliente'] = $info_usuario['id'];
    $_SESSION['nombre_cliente'] = $info_usuario['nombre'];
    $_SESSION['apellido_cliente'] = $info_usuario['apellido'];
    $_SESSION['ruc_cliente'] = $info_usuario['ruc'];
    $_SESSION['telefono_cliente'] = $info_usuario['telefono'];
    $_SESSION['direccion_cliente'] = $info_usuario['direccion'];
    $_SESSION['observacion_cliente'] = $info_usuario['observacion'];

    foreach ($_SESSION as $key => $value) {
        echo "Clave = " . $key . "------>" . $value . "<br>";
    }


    $stmt->close();
    $conn->close();

    header("Location: ../views/user/visitas.php");
?>
