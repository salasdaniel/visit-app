<?php
require '../config/user_validation.php';
require_once ('../../vendor/autoload.php');
require '../config/connection.php';



// Debug: Print received data

// Initialize products array
$selected_products = array();

// print_r($_POST['products']);

// Process products: look for 'product{id}' and 'quantity{id}' pairs
foreach ($_POST as $key => $value) {
    // Check if it's a product name field (product{id})
    if (strpos($key, 'product') === 0) {
        // Extract the product ID from the key (e.g., 'product4' -> '4')
        $product_id = substr($key, 7); // Remove 'product' prefix
        $quantity_key = 'quantity' . $product_id;
        
        // Check if the corresponding quantity exists and is greater than 0
        if (isset($_POST[$quantity_key]) && intval($_POST[$quantity_key]) > 0) {
            $product_name = $value;
            $quantity = intval($_POST[$quantity_key]);
            $selected_products[] = array($product_name, $quantity);
        }
    }
}

// Create formatted string for display/storage
$products_string = '';
if (!empty($selected_products)) {
    $product_strings = array();
    foreach ($selected_products as $product) {
        $product_strings[] = $product[0] . ' - ' . $product[1];
    }
    $products_string = implode(', ', $product_strings);
}



$_SESSION['products'] = $products_string;
$_SESSION['question_1'] = $_POST['question_1'];
$_SESSION['question_2'] = $_POST['question_2'];
$_SESSION['question_3'] = $_POST['question_3'];
$_SESSION['question_4'] = $_POST['question_4'];


if (isset($_POST['observations'])){
    $_SESSION['observations'] = $_POST['observations'];
}
    

$destination_folder = '../../images/';

// Check if the images folder exists, if not create it
if (!file_exists($destination_folder)) {
    if (!mkdir($destination_folder, 0755, true)) {
        print_r("Error: Could not create images directory.<br>");
        $_SESSION['upload_error'] = 1;
        die();
    }
}

// Generate base filename with date format: DDMMAAXX
$date_prefix = date('dmyy'); // Format: day(2) + month(2) + year(2)

// Function to generate unique filename with sequence
function generateUniqueFilename($destination_folder, $date_prefix, $sequence, $extension) {
    $sequence_str = str_pad($sequence, 2, '0', STR_PAD_LEFT); // Ensure 2 digits
    return $destination_folder . $date_prefix . $sequence_str . '.' . $extension;
}

// Function to get next available sequence number for the date
function getNextSequence($destination_folder, $date_prefix) {
    $sequence = 1;
    $pattern = $destination_folder . $date_prefix . '*';
    $existing_files = glob($pattern);
    
    if (!empty($existing_files)) {
        $max_sequence = 0;
        foreach ($existing_files as $file) {
            $basename = basename($file, '.' . pathinfo($file, PATHINFO_EXTENSION));
            if (strlen($basename) >= 8) {
                $file_sequence = intval(substr($basename, 6, 2)); // Get last 2 digits
                $max_sequence = max($max_sequence, $file_sequence);
            }
        }
        $sequence = $max_sequence + 1;
    }
    
    return $sequence;
}

$errors = false; // Control variable to track errors
$current_sequence = getNextSequence($destination_folder, $date_prefix);
print_r("<!-- Starting sequence number: $current_sequence -->");

for ($i = 1; $i <= count($_FILES); $i++) {
    $file_key = 'img' . $i;

    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
        $original_name = $_FILES[$file_key]['name'];
        $file_extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        
        // Generate new filename with sequence
        $new_filename = generateUniqueFilename($destination_folder, $date_prefix, $current_sequence, $file_extension);
        
        // Ensure filename is unique (in case of concurrent uploads)
        while (file_exists($new_filename)) {
            $current_sequence++;
            $new_filename = generateUniqueFilename($destination_folder, $date_prefix, $current_sequence, $file_extension);
        }

        if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $new_filename)) {
            $_SESSION[$file_key] = $new_filename;
            $current_sequence++; // Increment for next file
        } else {
         
            $_SESSION['msg'] = "Error uploading or renaming image $i.<br>";
            $_SESSION['msg_code'] = 2; // Mark that an error has occurred
            die(); // Stop execution and show error message
        }
    } else {
        $_SESSION['msg'] = "Error uploading image $i.<br>";
        $_SESSION['msg_code'] = 2; // Mark that an error has occurred
        die(); // Stop execution and show error message
    }
}

if (isset($_SESSION['msg']) && isset($_SESSION['msg_code'])) {
   
    error_log("Errors were found while uploading images.");
    header("Location: error_page.php");
    
} else {

    header("Location: ../views/user/exit.php");
}

// Helper function to get selected products as array
function getSelectedProducts() {
    return isset($_SESSION['selected_products']) ? $_SESSION['selected_products'] : array();
}

// Helper function to get products as formatted string
function getProductsString() {
    return isset($_SESSION['products']) ? $_SESSION['products'] : '';
}


?>

