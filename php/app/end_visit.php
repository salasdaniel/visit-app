<?php


require '../config/user_validation.php';
require '../config/connection.php';
require '../partials/head.php';
require_once ('../../vendor/autoload.php');

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

// Get entry and exit time
$entry_time = $_SESSION['entry_time'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$exit_time = date("H:i:s");

// Calculate time difference
$datetime1 = new DateTime($entry_time);
$datetime2 = new DateTime($exit_time);
$interval = $datetime1->diff($datetime2);
$time_difference = $interval->format('%H:%i:%s');

// Get visit data from session
$question_1 = $_SESSION['question_1'];
$question_2 = $_SESSION['question_2'];
$question_3 = $_SESSION['question_3'];
$question_4 = $_SESSION['question_4'];
$products = $_SESSION['products']; // Formatted string for database storage
$selected_products = isset($_SESSION['selected_products']) ? $_SESSION['selected_products'] : array(); // Array format for processing
$observations = $_SESSION['observations'];

// Debug: Show optimized products structure
echo "<!-- DEBUG: Selected Products Array -->";
echo "<!-- ";
print_r($selected_products);
echo " -->";

// Example: Create a detailed products list for WhatsApp message
$products_list = '';
if (!empty($selected_products)) {
    $products_list = "\n\n*Products requested by client:*\n";
    foreach ($selected_products as $product) {
        $products_list .= "• " . $product[0] . " (Qty: " . $product[1] . ")\n";
    }
}

$user_id = $_SESSION['user_id'];
$client_id = $_SESSION['client_id'];
$date = $_SESSION['date'];
$img1 = $_SESSION['img1'];
$img2 = $_SESSION['img2'];
$img3 = $_SESSION['img3'];
$img4 = $_SESSION['img4'];

// Insert visit into PostgreSQL database
$sql = "INSERT INTO visitas (id_cliente, id_responsable, fecha, hora_ingreso, hora_salida, tiempo_visita, agua, filtro, quimicos, necesita_productos, productos, observaciones, img_1, img_2, img_3, img_4) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16)";
$params = array($client_id, $user_id, $date, $entry_time, $exit_time, $time_difference, $question_1, $question_2, $question_3, $question_4, $products, $observations, $img1, $img2, $img3, $img4);
$result = pg_query_params($conn, $sql, $params);

// Get advisor name
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];

// Client phone
$phone = '+595' . $_SESSION['client_phone'];

// WhatsApp message 
$message = "Dear client,

Thank you for trusting *PROOPOL S.A*. You have recently been attended by our advisor, *$first_name $last_name*, on $date.

We constantly strive to provide the best possible service to our clients. To help us improve even more, we kindly ask for your valuable feedback. Please rate your experience with us on a scale from 1 to 5, where 1 is unsatisfactory and 5 is excellent.";

// Add products list if client requested products
if ($question_4 === 'si' && !empty($selected_products)) {
    $message .= $products_list;
}

$message .= "

Your feedback is essential to us and will help us improve and continue providing you with excellent service.

*Thank you again for choosing PROOPOL S.A!*";

// Convert image path to URL for sending
$img2 = substr($img2, 6);
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$serverName = $_SERVER['SERVER_NAME'];
$port = $_SERVER['SERVER_PORT'];
$basePath = dirname($_SERVER['SCRIPT_NAME']);
// Full image URL
$imageUrl = "$protocol://$serverName:$port/$img2";

// WhatsApp message sending

$ultramsg_token = $_ENV['ULTRAMSG_TOKEN']; // Ultramsg.com token
$instance_id = $_ENV['ULTRAMSG_INSTANCE']; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($ultramsg_token, $instance_id);
$image = "$imageUrl";

// echo $image;

$priority = 10;
$referenceId = "SDK";
$nocache = false;

// Send WhatsApp image message
$api = $client->sendImageMessage($phone, $image, $message, $priority, $referenceId, $nocache);

// Handle WhatsApp API response
// print_r($api);
if (isset($api['Error'])) {
    $response = $api['Error'];
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Message could not be sent! $response',
            showConfirmButton: false,
            timer: 1800
        });
        setTimeout(function() {
            window.location.href = '../../php/app/logout.php';
        }, 2000);
        </script>";
    print_r($api);
    var_dump($response);
} elseif (isset($api['sent'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Message sent successfully',
            showConfirmButton: false,
            timer: 1500
        });
        setTimeout(function() {
            window.location.href = '../../php/app/logout.php';
        }, 1700);
        </script>";
}


?>