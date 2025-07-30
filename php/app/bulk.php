<?php
require '../config/admin_validation.php';
require '../../vendor/autoload.php';
require '../config/connection.php';

use PhpOffice\PhpSpreadsheet\IOFactory;


if (isset($_FILES['excel_file']['name'])) {
    $file_name = $_FILES['excel_file']['name'];
    $temp_name = $_FILES['excel_file']['tmp_name'];

    // Load the Excel file
    $spreadsheet = IOFactory::load($temp_name);

    // Get the worksheet
    $worksheet = $spreadsheet->getActiveSheet();
    $first_row = true;

    // Iterate through rows and process in a single loop
    $duplicate_documents = array();
    $inserted_count = 0;
    $first_row = true;
    foreach ($worksheet->getRowIterator() as $row) {
        if ($first_row) {
            $first_row = false;
            continue;
        }
        // Read data from each cell
        $data = $row->getCellIterator();
        $row_data = [];
        foreach ($data as $cell) {
            $row_data[] = $cell->getValue();
        }
        $first_name = $row_data[0];
        $last_name = $row_data[1];
        $document = $row_data[2];
        $phone = $row_data[3];
        $address = $row_data[4];
        $plan = $row_data[5];
        $observation = $row_data[6];
        if (validateDocument($document)) {
            try {
                $sql = "INSERT INTO customers (first_name, last_name, tax_id, phone, address, subscription_plan, notes) VALUES ($1, $2, $3, $4, $5, $6, $7)";
                $params = array($first_name, $last_name, $document, $phone, $address, $plan, $observation);
                $result = pg_query_params($conn, $sql, $params);
                if ($result) {
                    $inserted_count++;
                }
            } catch (Exception $e) {
                $_SESSION['msg'] = 'Error inserting client: ' . $e->getMessage();
                $_SESSION['msg_code'] = 2;
                header("Location: ../views/admin/clients.php");
                exit();
            }
        } else {
            $duplicate_documents[] = $document;
        }
    }

    session_start();
    if ($inserted_count > 0 && count($duplicate_documents) > 0) {
        $docs = implode(', ', $duplicate_documents);
        $_SESSION['msg'] = "Records added: $inserted_count; Some records were not inserted due to duplicate documents: $docs";
        $_SESSION['msg_code'] = 2;
    } else if ($inserted_count > 0) {
        $_SESSION['msg'] = 'Records added: ' . $inserted_count;
        $_SESSION['msg_code'] = 1;
    } else if (count($duplicate_documents) > 0) {
        $docs = implode(', ', $duplicate_documents);
        $_SESSION['msg'] = "No records added. Some records were not inserted due to duplicate documents: $docs";
        $_SESSION['msg_code'] = 2;
    }
    header("Location: ../views/admin/clients.php");
    exit();

}

function validateDocument($document) {
    global $conn;
    try {
        $sql = "SELECT 1 FROM customers WHERE tax_id = $1";
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
