<?php
require '../config/user_validation.php';
require '../config/connection.php';

try {
    // Basic validation - check if client ID is provided
    if (!isset($_POST['client_id']) || empty($_POST['client_id'])) {
        throw new Exception('Client ID is required');
    }

    // Validate and sanitize client ID
    $client_id = filter_var($_POST['client_id'], FILTER_VALIDATE_INT);
    

    // PostgreSQL query with parameterized statement
    $query = "SELECT id, nombre, apellido, ruc, telefono, direccion, observacion 
              FROM clientes 
              WHERE id = $1 AND activo = true";
    
    $result = pg_query_params($conn, $query, array($client_id));
    
    if (!$result) {
        throw new Exception('Database error: ' . pg_last_error($conn));
    }

    $client_info = pg_fetch_assoc($result);


    // Store client information in session 
    $_SESSION['client_id'] = $client_info['id'];
    $_SESSION['client_name'] = $client_info['nombre'] ?? '';
    $_SESSION['client_lastname'] = $client_info['apellido'] ?? '';
    $_SESSION['client_ruc'] = $client_info['ruc'] ?? '';
    $_SESSION['client_phone'] = $client_info['telefono'] ?? '';
    $_SESSION['client_address'] = $client_info['direccion'] ?? '';
    $_SESSION['client_observation'] = $client_info['observacion'] ?? '';

    // Clean up resources
    pg_free_result($result);
    pg_close($conn);

    // Redirect to visits page
    header("Location: ../views/user/visits.php");
    exit();

} catch (Exception $e) {
    // Log error and clean up
    error_log('Error in check_client.php: ' . $e->getMessage());
    pg_close($conn);
    // Redirect back with error message
    $_SESSION['msg'] = $e->getMessage();
    $_SESSION['msg_code'] = 2;
    header("Location: ../views/user/advisor.php");
    exit();
}
?>
