<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Advanced Contact Form with File Uploader">
    <meta name="author" content="UWS">
    <title>Propool | Visitas </title>

    <!-- Favicon -->
    <link href="../../../img/favicon.png" rel="shortcut icon">

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="../../../vendor/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Custom Font Icons -->
    <link href="../../../vendor/icomoon/css/iconfont.min.css" rel="stylesheet">

    <!-- Vendor CSS -->
  
    <link href="../../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../vendor/dmenu/css/menu.css" rel="stylesheet">
    <link href="../../../vendor/hamburgers/css/hamburgers.min.css" rel="stylesheet">
    <link href="../../../vendor/mmenu/css/mmenu.min.css" rel="stylesheet">
    <link href="../../../vendor/filepond/css/filepond.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="../../../css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="../../../vendor/jquery/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
	
</head>



<?php

require '../config/conexion.php';
require_once ('../../vendor/autoload.php');

session_start();
$entrada = $_SESSION['hora_entrada'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$salida = date("H:i:s");

$datetime1 = new DateTime($entrada);
$datetime2 = new DateTime($salida);
$interval = $datetime1->diff($datetime2);
$diferencia = $interval->format('%H:%i:%s');

// echo $entrada."<br>".$salida."<br>".$diferencia."<br>";

$entrada = $_SESSION['hora_entrada'];
$pregunta1 = $_SESSION['pregunta_1'];
$pregunta2 = $_SESSION['pregunta_2'];
$pregunta3 = $_SESSION['pregunta_3'];
$pregunta4 = $_SESSION['pregunta_4'];
$productos = $_SESSION['productos'];
$observaciones = $_SESSION['observaciones'];

$id_usuario = $_SESSION['id'];
$id_cliente = $_SESSION['id_cliente'];

$fecha = $_SESSION['fecha'];
$img1 = $_SESSION['img1'];
$img2 = $_SESSION['img2'];
$img3 = $_SESSION['img3'];
$img4 = $_SESSION['img4'];


$sql = "INSERT INTO visitas VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?) ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissssssssssssss", $id_cliente, $id_usuario , $fecha, $entrada, $salida, $diferencia, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $productos, $observaciones, $img1, $img2, $img3, $img4  );
$stmt->execute();


$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

// foreach ($_SESSION as $clave => $valor) {
//     echo "$clave ----> $valor <br>";
// }

$tlf = '+595'.$_SESSION['telefono_cliente'];

$mensaje = "Estimado cliente,

Esperamos que te encuentres bien. Queremos agradecerte por haber confiado en *PROOPOL S.A*. Recientemente, has sido atendido por nuestro asesor, *$nombre $apellido*, en la fecha $fecha.

Nos esforzamos constantemente por brindar el mejor servicio posible a nuestros clientes. Para ayudarnos a mejorar aún más, te pedimos que nos brindes tu valiosa opinión. Por favor, califica tu experiencia con nosotros en una escala del 1 al 5, donde 1 es insatisfactorio y 5 es excelente.

Tu comentario es esencial para nosotros y nos ayudará a mejorar y continuar brindándote un excelente servicio. 

*¡Gracias nuevamente por elegir PROOPOL S.A!*
";

//-------- Convertir ruta en URL para envio ----------------

$img2 = substr($img2, 6);

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Dominio del servidor
$serverName = $_SERVER['SERVER_NAME'];

// Puerto del servidor
$port = $_SERVER['SERVER_PORT'];

// Ruta base de la aplicación (puede variar dependiendo de tu configuración)
$basePath = dirname($_SERVER['SCRIPT_NAME']);
// Eliminar "/php/app/" de la ruta base si existe


// URL completa de la imagen
$imageUrl = "$protocol://$serverName:$port/$img2";

// ------------ mensaje de whatsapp -----------------------------

$ultramsg_token="nm5zjeuc3ubdxgga"; // Ultramsg.com token
$instance_id="instance64170"; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);
$image= "$imageUrl"; 

echo $image;

// $caption="image Caption"; 
$priority=10;
$referenceId="SDK";
$nocache=false; 

// $api=$client->sendChatMessage($tlf,$mensaje);

$api=$client->sendImageMessage($tlf,$image,$mensaje,$priority,$referenceId,$nocache);


if (isset($api['error'])){
    $respuesta = $api['error'];
    echo "<script>
           
            alert('No se pudo enviar el mensaje! $respuesta')
            
            setTimeout(function() {
                window.location.href = '../../php/app/logout.php';
            }, 1500); 
            

			</script>";

                        var_dump($respuesta);

    // header("Location:../../php/app/logout.php");
}elseif (isset($api['sent'])){
    echo "<script>
            
            alert('Mensaje enviado con exito')

            setTimeout(function() {
                window.location.href = '../../php/app/logout.php';
            }, 1500); 
            
				</script>";
//     // header("Location:../../php/app/logout.php");
}
// var_dump($api);
// print_r($api);
// header("Location:../../php/app/logout.php");

// var_dump($_SESSION);


?>