<?php

require '../config/connection.php';
// Tu código para conectarte a la base de datos y configurar la paginación aquí

// Consulta SQL para obtener todos los registros (sin limitación de página)
$sql = "SELECT id, CONCAT (cliente_nombre,' ', cliente_apellido) as nombre_cliente, CONCAT(persona_nombre,' ', persona_apellido) as nombre_asesor,
fecha, hora_ingreso, hora_salida, tiempo_visita, agua, filtro, quimicos, necesita_productos, productos, observaciones
FROM vw_visitas";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Ejecuta la consulta
// $resultado = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Configura las cabeceras HTTP para la descarga del archivo CSV
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=tabla_completa.csv");

// Abre un flujo de salida para escribir el archivo CSV
$archivo_csv = fopen("php://output", "w");

// Escribe las cabeceras del archivo CSV (si es necesario)
fputcsv($archivo_csv, array('ID', 'NOMBRE_CLIENTE', 'NOMBRE_ASESOR', 'FECHA', 'HORA_INGRESO', 'HORA_SALIDA', 'TIEMPO_VISITA', 'AGUA', 'FILTRO', 'QUIMICOS', 'NECESITA_PRODUCTOS', 'PEDIDO', 'OBSERVACIONES'));

// Itera sobre los resultados de la consulta y escribe cada fila en el archivo CSV
while ($fila = $result->fetch_assoc()) {
    fputcsv($archivo_csv, $fila);
}

// Cierra el flujo de salida
fclose($archivo_csv);

// Cierra la conexión a la base de datos (si es necesario)
$stmt->close();
$conn->close();
?>
