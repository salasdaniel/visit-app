<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../views/login.php');
    exit();
}

require_once '../config/database.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit']) && isset($_FILES['archivo_excel'])) {
    $archivo_temporal = $_FILES['archivo_excel']['tmp_name'];
    $archivo_nombre = $_FILES['archivo_excel']['name'];
    
    // Validate file extension
    $extension = pathinfo($archivo_nombre, PATHINFO_EXTENSION);
    if (!in_array(strtolower($extension), ['xlsx', 'xls'])) {
        $_SESSION['mensaje'] = 'Only .xlsx and .xls files are allowed.';
        $_SESSION['tipo_mensaje'] = 'error';
        header('Location: ../views/admin/productos.php');
        exit();
    }
    
    try {
        // Load the spreadsheet
        $spreadsheet = IOFactory::load($archivo_temporal);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        // Remove header row
        array_shift($rows);
        
        $successful_imports = 0;
        $failed_imports = 0;
        $duplicate_products = [];
        $error_details = [];
        
        foreach ($rows as $index => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }
            
            $row_number = $index + 2; // +2 because we removed header and arrays are 0-indexed
            
            // Validate required fields
            if (empty($row[0]) || empty($row[1]) || !is_numeric($row[1]) || !is_numeric($row[2])) {
                $failed_imports++;
                $error_details[] = "Row $row_number: Invalid data format";
                continue;
            }
            
            $nombre = trim($row[0]);
            $costo = floatval($row[1]);
            $venta = floatval($row[2]);
            $id_usuario_creacion = $_SESSION['id_usuario'];
            
            // Validate prices
            if ($costo < 0 || $venta < 0) {
                $failed_imports++;
                $error_details[] = "Row $row_number: Prices cannot be negative";
                continue;
            }
            
            // Check for duplicates
            $check_sql = "SELECT id FROM productos WHERE LOWER(nombre) = LOWER($1)";
            $check_result = pg_query_params($conn, $check_sql, array($nombre));
            
            if (pg_num_rows($check_result) > 0) {
                $failed_imports++;
                $duplicate_products[] = $nombre;
                continue;
            }
            
            // Get next sequence value
            $seq_result = pg_query($conn, "SELECT nextval('productos_id_seq')");
            if (!$seq_result) {
                $failed_imports++;
                $error_details[] = "Row $row_number: Error generating product ID";
                continue;
            }
            $new_id = pg_fetch_result($seq_result, 0, 0);
            
            // Insert product
            $insert_sql = "INSERT INTO productos (id, nombre, costo, venta, id_usuario_creacion) 
                          VALUES ($1, $2, $3, $4, $5)";
            $insert_result = pg_query_params($conn, $insert_sql, array(
                $new_id,
                $nombre,
                $costo,
                $venta,
                $id_usuario_creacion
            ));
            
            if ($insert_result) {
                $successful_imports++;
            } else {
                $failed_imports++;
                $error_details[] = "Row $row_number: Database error - " . pg_last_error($conn);
            }
        }
        
        // Prepare success message
        $message_parts = [];
        if ($successful_imports > 0) {
            $message_parts[] = "$successful_imports products imported successfully";
        }
        if ($failed_imports > 0) {
            $message_parts[] = "$failed_imports records failed";
        }
        
        $message = implode(', ', $message_parts);
        
        if (!empty($duplicate_products)) {
            $message .= ". Duplicates found: " . implode(', ', array_slice($duplicate_products, 0, 5));
            if (count($duplicate_products) > 5) {
                $message .= " and " . (count($duplicate_products) - 5) . " more";
            }
        }
        
        if (!empty($error_details) && count($error_details) <= 10) {
            $message .= ". Errors: " . implode('; ', $error_details);
        }
        
        $_SESSION['mensaje'] = $message;
        $_SESSION['tipo_mensaje'] = $successful_imports > 0 ? 'success' : 'warning';
        
    } catch (Exception $e) {
        $_SESSION['mensaje'] = 'Error processing file: ' . $e->getMessage();
        $_SESSION['tipo_mensaje'] = 'error';
    }
} else {
    $_SESSION['mensaje'] = 'No file was uploaded or invalid request.';
    $_SESSION['tipo_mensaje'] = 'error';
}

header('Location: ../views/admin/productos.php');
exit();
?>
