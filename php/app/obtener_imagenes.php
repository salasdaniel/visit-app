<?php

require '../config/conexion.php';

$id = $_GET['id'];



$sql = "SELECT img_1, img_2, img_3, img_4 FROM visitas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$rutas = $result->fetch_assoc();

$img_1 = $rutas['img_1'];
$img_2 = $rutas['img_2'];
$img_3 = $rutas['img_3'];
$img_4 = $rutas['img_4'];


$imagenes = array($img_1, $img_2, $img_3, $img_4);
// var_dump($imagenes."<br>". "<br>");

$stmt->close();
$conn->close();

echo json_encode($imagenes);


?>
