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

    // Iterar a través de las filas
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

        // Validar y procesar los datos
        $nombre = $rowData[0];
        $apellido = $rowData[1];
        $ci = $rowData[2];
        $numero = $rowData[3];
        $direccion = $rowData[4];
        $plan = $rowData[5];
        $observacion = $rowData[6];

        if (validarCI($ci)) {
            try {
            
                // Realizar la inserción en la base de datos
                $sql = "INSERT INTO clientes VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssss", $nombre, $apellido, $ci, $numero, $direccion, $plan, $observacion);
                $stmt->execute();

                // if ($stmt->affected_rows > 0) {
                //     // Inserción exitosa
                //     echo "Inserción exitosa";
                // } else {
                //     // No se insertaron filas
                //     echo "No se insertaron filas";
                // }
                
            } catch (Exception $e) {
                echo "Error en la inserción: " . $e->getMessage();
            }
        } else {
            echo "<script>alert(' El RUC número = $ci ya existe en la base de datos!')</script>";
        }
    }
     
    $filas = $worksheet->getRowIterator();
    $end = end($filas);

    if ($end){

        session_start();
        $_SESSION['msj'] = 'Registros insertados con exito';
        $_SESSION['msj_code'] = 1;

        echo '<script>
        setTimeout(function() {
            window.location.href = "../views/admin/clientes.php"; 
        }, 2000); 
        </script>';
    }

}

function validarCI($ci) {
    global $conn;

    try {
        $sql = "SELECT * FROM clientes WHERE ruc = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ci);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false; // El número de CI ya existe en la base de datos, es inválido
        } else {
            return true; // El número de CI no existe en la base de datos, es válido
        }
    } catch (Exception $e) {
        echo "Error en la validación: " . $e->getMessage();
        return false;
    }
}
