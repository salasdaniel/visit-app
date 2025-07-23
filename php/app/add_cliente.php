<?php

session_start();
require '../config/conexion.php';

$nombre = trim(strtoupper($_POST['nombre']));
$apellido = trim(strtoupper($_POST['apellido']));
$ruc = trim($_POST['ruc']);
$numero = trim($_POST['numero']);
$direccion = strtolower($_POST['direccion']);
$plan = trim(strtoupper($_POST['plan']));
$observacion = strtolower($_POST['observacion']);

$sql = "SELECT * FROM clientes WHERE ruc = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ruc);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $_SESSION['msj'] = "El documento ingresado, ya se encuentra registrado en la base de datos.";
    $_SESSION['msj_code'] = 0;
    header("Location: ../views/admin/clientes.php");
    
} elseif ($result->num_rows <= 0) {

    $stmt->close();
    $sql = "INSERT INTO clientes VALUES (NULL,?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $apellido, $ruc, $numero, $direccion, $plan, $observacion);


    if ($stmt->execute()) {

        if ($_SESSION['rol'] == 1) {
            header("Location: ../views/admin/clientes.php");
        } else {
            header("Location:../views/user/vista_vendedor.php");
        }
        $_SESSION['msj'] = "Se ha registrado un nuevo cliente en base de datos.";
        $_SESSION['msj_code'] = 1;
    } else {
        $_SESSION['msj'] = "¡Error al comunicarse con la Base de Datos!";
        $_SESSION['msj_code'] = 2;
    }
}

$stmt->close();
$conn->close();

?>
