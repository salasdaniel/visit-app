<?php
require '../config/user_validation.php';
require_once ('../../vendor/autoload.php');
require '../config/conexion.php';



$order = array();
$product_count = $_POST['quantity'];

for ($i = 1; $i <= $product_count; $i++) {
    $product_key = "Product" . $i;
    $quantity_key = "Quantity" . $i;

    // Check if the product and quantity are present in $_POST
    if (isset($_POST[$product_key]) && $_POST[$quantity_key] != 0) {
        $product_name = $_POST[$product_key];
        $quantity = $_POST[$quantity_key];
        $order[$product_name] = $quantity;
    }
}

// $products_with_quantity will contain the products with their quantities
$selection = '';

foreach ($order as $key => $value) {
    // $key is the field name and $value is the submitted value
    $selection .= "$key - $value". ', ';
}


$string = rtrim($selection, ', ');
$_SESSION['products'] = $string;

echo $string;

$_SESSION['question_1'] = $_POST['question_1'];
$_SESSION['question_2'] = $_POST['question_2'];
$_SESSION['question_3'] = $_POST['question_3'];
$_SESSION['question_4'] = $_POST['question_4'];


if (isset($_POST['observations'])){
    $_SESSION['observations'] = $_POST['observations'];
}
    






// $destination_folder = '../../images/';

// for ($i = 1; $i <= count($_FILES); $i++) {
//     $file_key = 'img' . $i;

//     if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
//         $file_name = $_FILES[$file_key]['name'];
//         $destination_file = $destination_folder . $file_name;

//         if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $destination_file)) {
//             $_SESSION[$file_key] = $destination_file;
//         } else {
//              "Error uploading or renaming image $i.<br>";
//             $_SESSION['rename_error'] = 1;
//             break;
//         }
//     } else {
//         echo "Error uploading image $i.<br>";
//         $_SESSION['upload_error'] = 1;
//     }

//     $_SESSION['upload_error'] = 0;
// }

$destination_folder = '../../images/';

// Check if the images folder exists, if not create it
if (!file_exists($destination_folder)) {
    if (!mkdir($destination_folder, 0755, true)) {
        echo "Error: Could not create images directory.<br>";
        $_SESSION['upload_error'] = 1;
        die();
    }
}

$errors = false; // Control variable to track errors

for ($i = 1; $i <= count($_FILES); $i++) {
    $file_key = 'img' . $i;

    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES[$file_key]['name'];
        $destination_file = $destination_folder . $file_name;

        if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $destination_file)) {
            $_SESSION[$file_key] = $destination_file;
        } else {
            echo "Error uploading or renaming image $i.<br>";
            $_SESSION['rename_error'] = 1;
            $errors = true; // Mark that an error has occurred
            die(); // Stop execution and show error message
        }
    } else {
        echo "Error uploading image $i.<br>";
        $_SESSION['upload_error'] = 1;
        $errors = true; // Mark that an error has occurred
        die(); // Stop execution and show error message
    }
}

if ($errors) {
    // You can log the error here if necessary
    error_log("Errors were found while uploading images.");
    // You can redirect to an error page if desired
    header("Location: error_page.php");
} else {
    // No errors found, redirect to desired page
    header("Location: ../views/user/exit.php");
}


// header("Location:../views/user/qr_salida.php");
// header("Location:../app/envio.php");
// var_dump($_SESSION)

?>

