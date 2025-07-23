<?php

	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$database = "propool_app";
	
	// Crea una conexión a la base de datos
	$conn = new mysqli($servername, $username, $password, $database);
	
	// Verifica si la conexión fue exitosa
	if ($conn->connect_error) {
		die("Error de conexión: " . $conn->connect_error);
	}

	

?>
