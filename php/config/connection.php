<?php

// Define BASE_URL based on environment
if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost:8080') {
    // Docker environment
    define('BASE_URL', '/');
} else {
    // Local development environment
    define('BASE_URL', '/mis-repositorios/visit-app/');
}


require_once(dirname(__DIR__, 2) . '/vendor/autoload.php');
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

// Crea una conexión a la base de datos PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Verifica si la conexión fue exitosa
if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}
