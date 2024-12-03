<?php
// conexion.php

// Cargar las variables de entorno
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuración de la conexión
$servername = $_ENV['SUPABASE_HOST'];
$username = $_ENV['SUPABASE_USER'];
$password = $_ENV['SUPABASE_PASSWORD'];
$database = $_ENV['SUPABASE_DB'];

// Crear la conexión con PostgreSQL
$conn = pg_connect("host=$servername dbname=$database user=$username password=$password");

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
}
?>
