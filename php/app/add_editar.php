<?php

session_start();
require '../config/conexion.php';

// var_dump($_POST);
$id = $_POST['id'];
$nombre = trim(strtoupper($_POST['nombre']));
$apellido = trim(strtoupper($_POST['apellido']));
$ruc = trim($_POST['ruc']);
$numero = trim($_POST['numero']);
$direccion = strtolower($_POST['direccion']);
$dia = trim(strtoupper($_POST['dia']));
$hora = $_POST['hora'];
$observacion = strtolower($_POST['observacion']);


$sql = "UPDATE clientes
            SET nombre = ?, apellido = ?, ruc = ?, telefono = ?, direccion = ?, dia_visita = ?, horario_visita = ?, observacion = ?
            WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssi", $nombre, $apellido, $ruc, $numero, $direccion, $dia, $hora, $observacion, $id);
$stmt->execute();
$result = $stmt->get_result();


if ($stmt->execute()) {
    $_SESSION['msj'] = "Los datos han sido actualizados con éxito.";
    $_SESSION['msj_code'] = 1;
    header("Location:  ../views/admin/clientes.php");
} else {
    $_SESSION['msj'] = "¡Error al comunicarse con la Base de Datos!";
    $_SESSION['msj_code'] = 2;
}

$stmt->close();
$conn->close();

?>
