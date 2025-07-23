<?php
session_start();
require_once ('../../vendor/autoload.php');
require '../config/conexion.php';



$pedido = array();
$cant_productos = $_POST['cant_productos'];

for ($i = 1; $i <= $cant_productos; $i++) {
    $producto_key = "producto" . $i;
    $cantidad_key = "cantidad" . $i;

    // Verifica si el producto y la cantidad están presentes en $_POST
    if (isset($_POST[$producto_key]) && $_POST[$cantidad_key] != 0) {
        $producto_nombre = $_POST[$producto_key];
        $cantidad = $_POST[$cantidad_key];
        $pedido[$producto_nombre] = $cantidad;
    }
}

// $productos_con_cantidad contendrá los productos con sus cantidades
$seleccion = '';

foreach ($pedido as $key => $value) {
    // $key es el nombre del campo y $value es el valor enviado
    $seleccion .= "$key - $value". ', ';
}


$string = rtrim($seleccion, ', ');
$_SESSION['productos'] = $string;

echo $string;

$_SESSION['pregunta_1'] = $_POST['pregunta_1'];
$_SESSION['pregunta_2'] = $_POST['pregunta_2'];
$_SESSION['pregunta_3'] = $_POST['pregunta_3'];
$_SESSION['pregunta_4'] = $_POST['pregunta_4'];


if (isset($_POST['observaciones'])){

    $_SESSION['observaciones'] = $_POST['observaciones'];
}
    






// $carpeta_destino = '../../images/';

// for ($i = 1; $i <= count($_FILES); $i++) {
//     $file_key = 'img' . $i;

//     if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
//         $nombre_archivo = $_FILES[$file_key]['name'];
//         $archivo_destino = $carpeta_destino . $nombre_archivo;

//         if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $archivo_destino)) {
//             $_SESSION[$file_key] = $archivo_destino;
//         } else {
//              "Error al cargar o renombrar la imagen $i.<br>";
//             $_SESSION['rename_error'] = 1;
//             break;
//         }
//     } else {
//         echo "Error al cargar la imagen $i.<br>";
//         $_SESSION['upload_error'] = 1;
//     }

//     $_SESSION['upload_error'] = 0;
// }

$carpeta_destino = '../../images/';
$errores = false; // Variable de control para rastrear errores

for ($i = 1; $i <= count($_FILES); $i++) {
    $file_key = 'img' . $i;

    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = $_FILES[$file_key]['name'];
        $archivo_destino = $carpeta_destino . $nombre_archivo;

        if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $archivo_destino)) {
            $_SESSION[$file_key] = $archivo_destino;
        } else {
            echo "Error al cargar o renombrar la imagen $i.<br>";
            $_SESSION['rename_error'] = 1;
            $errores = true; // Marcar que ha ocurrido un error
            die(); // Detiene la ejecución y muestra el mensaje de error
        }
    } else {
        echo "Error al cargar la imagen $i.<br>";
        $_SESSION['upload_error'] = 1;
        $errores = true; // Marcar que ha ocurrido un error
        die(); // Detiene la ejecución y muestra el mensaje de error
    }
}

if ($errores) {
    // Puedes registrar el error en el log aquí si es necesario
    error_log("Se encontraron errores al cargar imágenes.");
    // Puedes redirigir a una página de error si lo deseas
    header("Location: error_page.php");
} else {
    // No se encontraron errores, redirige a la página deseada
    header("Location: ../views/user/qr_salida.php");
}


// header("Location:../views/user/qr_salida.php");
// header("Location:../app/envio.php");
// var_dump($_SESSION)

?>

