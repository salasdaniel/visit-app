<?php

// Check if user is logged in
require '../config/admin_validation.php';
require '../../vendor/autoload.php';
require '../config/connection.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


if (isset($_FILES['excel_file']['name'])) {
    $created_user = $_SESSION['user_id'];
    $fileName = $_FILES['excel_file']['name'];
    $tmpName = $_FILES['excel_file']['tmp_name'];

    $spreadsheet = IOFactory::load($tmpName);

    
    $worksheet = $spreadsheet->getActiveSheet();
    $firstRow = true;

    
    $duplicateDocuments = array();
    $insertedCount = 0;
    $firstRow = true;
    foreach ($worksheet->getRowIterator() as $row) {
        if ($firstRow) {
            $firstRow = false;
            continue;
        }
      
        $data = $row->getCellIterator();
        $rowData = [];
        foreach ($data as $cell) {
            $rowData[] = $cell->getValue();
        }
        $product_name = $rowData[0];
        $cost_price = $rowData[1];
        $sale_price = $rowData[2];
      

        if (validateDocument($product_name)) {
            try {
                $sql = "INSERT INTO products (name, cost_price, sale_price, created_user) VALUES ($1, $2, $3, $4)";
                $params = array($product_name, $cost_price, $sale_price, $created_user);
                $result = pg_query_params($conn, $sql, $params);
                if ($result) {
                    $insertedCount++;
                }
            } catch (Exception $e) {
                $_SESSION['msg'] = 'Error inserting product: ' . $e->getMessage();
                $_SESSION['msg_code'] = 2;
                header("Location: ../views/admin/products.php");
                exit();
            }
        } else {
            $duplicateDocuments[] = $product_name;
        }
    }

    session_start();
    if ($insertedCount > 0 && count($duplicateDocuments) > 0) {
        $docs = implode(', ', $duplicateDocuments);
        $_SESSION['msg'] = "Records added: $insertedCount; Some records were not inserted due to duplicate name: $docs";
        $_SESSION['msg_code'] = 2;
    } else if ($insertedCount > 0) {
        $_SESSION['msg'] = 'Records added: ' . $insertedCount;
        $_SESSION['msg_code'] = 1;
    } else if (count($duplicateDocuments) > 0) {
        $docs = implode(', ', $duplicateDocuments);
        $_SESSION['msg'] = "No records added. Some records were not inserted due to duplicate name: $docs";
        $_SESSION['msg_code'] = 2;
    }
    header("Location: ../views/admin/products.php");
    exit();
}

function validateDocument($product_name)
{
    global $conn;
    try {
        $sql = "SELECT 1 FROM products WHERE name = $1";
        $result = pg_query_params($conn, $sql, array($product_name));
        if (pg_num_rows($result) > 0) {
            return false; // document already exists
        } else {
            return true; // document does not exist
        }
    } catch (Exception $e) {
        echo "Error validating product name: " . $e->getMessage();
        return false;
    }
}
