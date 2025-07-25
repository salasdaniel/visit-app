<?php
require '../../vendor/autoload.php';
require '../config/conexion.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$registrosNoInsertados = [];

if (isset($_FILES['archivo_excel']['name'])) {
    $nombreArchivo = $_FILES['archivo_excel']['name'];
    $tmpNombre = $_FILES['archivo_excel']['tmp_name'];

    // Cargar el archivo Excel
    $spreadsheet = IOFactory::load($tmpNombre);

    // Obtener la hoja de trabajo
    $worksheet = $spreadsheet->getActiveSheet();
    $firstRow = true;

    // Iterar a través de las filas y procesar en un solo ciclo
    $duplicateDocuments = array();
    $insertedCount = 0;
    $firstRow = true;
    foreach ($worksheet->getRowIterator() as $row) {
        if ($firstRow) {
            $firstRow = false;
            continue;
        }
        // Leer los datos de cada celda
        $data = $row->getCellIterator();
        $rowData = [];
        foreach ($data as $cell) {
            $rowData[] = $cell->getValue();
        }
        $first_name = $rowData[0];
        $last_name = $rowData[1];
        $document = $rowData[2];
        $phone = $rowData[3];
        $address = $rowData[4];
        $plan = $rowData[5];
        $observation = $rowData[6];
        if (validateDocument($document)) {
            try {
                $sql = "INSERT INTO clientes (nombre, apellido, ruc, telefono, direccion, plan, observacion) VALUES ($1, $2, $3, $4, $5, $6, $7)";
                $params = array($first_name, $last_name, $document, $phone, $address, $plan, $observation);
                $result = pg_query_params($conn, $sql, $params);
                if ($result) {
                    $insertedCount++;
                }
            } catch (Exception $e) {
                // ...existing code...
            }
        } else {
            $duplicateDocuments[] = $document;
        }
    }

    session_start();
    if ($insertedCount > 0 && count($duplicateDocuments) > 0) {
        $docs = implode(', ', $duplicateDocuments);
        $_SESSION['msg'] = "Records added: $insertedCount; Some records were not inserted due to duplicate documents: $docs";
        $_SESSION['msg_code'] = 2;
    } else if ($insertedCount > 0) {
        $_SESSION['msg'] = 'Records added: ' . $insertedCount;
        $_SESSION['msg_code'] = 1;
    } else if (count($duplicateDocuments) > 0) {
        $docs = implode(', ', $duplicateDocuments);
        $_SESSION['msg'] = "No records added. Some records were not inserted due to duplicate documents: $docs";
        $_SESSION['msg_code'] = 2;
    }
    header("Location: ../views/admin/clients.php");
    exit();

}

function validateDocument($document) {
    global $conn;
    try {
        $sql = "SELECT 1 FROM clientes WHERE ruc = $1";
        $result = pg_query_params($conn, $sql, array($document));
        if (pg_num_rows($result) > 0) {
            return false; // document already exists
        } else {
            return true; // document does not exist
        }
    } catch (Exception $e) {
        echo "Error validating document: " . $e->getMessage();
        return false;
    }
}
