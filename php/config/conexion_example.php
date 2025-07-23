<?php

$host = "localhost";
$port = "5432";
$dbname = "autoflet";
$user = "postgres";
$password = "7650926";

// Crea una conexión a la base de datos PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Verifica si la conexión fue exitosa
if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}
