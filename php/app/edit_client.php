<?php

session_start();
require '../config/conexion.php';

$id = $_POST['id'];
$first_name = trim(strtoupper($_POST['nombre']));
$last_name = trim(strtoupper($_POST['apellido']));
$ruc = trim($_POST['ruc']);
$phone = trim($_POST['numero']);
$address = strtolower($_POST['direccion']);
$visit_day = trim(strtoupper($_POST['dia']));
$visit_time = $_POST['hora'];
$observation = strtolower($_POST['observacion']);

$sql = "UPDATE clientes
            SET nombre = $1, apellido = $2, ruc = $3, telefono = $4, direccion = $5, dia_visita = $6, horario_visita = $7, observacion = $8
            WHERE id = $9";
$params = array($first_name, $last_name, $ruc, $phone, $address, $visit_day, $visit_time, $observation, $id);
$result = pg_query_params($conn, $sql, $params);

if ($result) {
    $_SESSION['msg'] = "Client data has been updated successfully.";
    $_SESSION['msg_code'] = 1;
    header("Location: ../views/admin/clients.php");
    exit;
} else {
    $_SESSION['msg'] = "Error communicating with the database!";
    $_SESSION['msg_code'] = 2;
    header("Location: ../views/admin/clients.php");
    exit;
}

pg_close($conn);

?>
