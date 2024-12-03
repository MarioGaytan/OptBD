<?php
// conexion.php a

$servername = getenv('MYSQLHOST'); // Nombre del host
$username = getenv('MYSQLUSER'); // Usuario de la base de datos
$password = getenv('MYSQLPASSWORD'); // Contraseña
$database = getenv('MYSQLDATABASE'); // Nombre de la base de datos
$port = getenv('MYSQLPORT'); // Puerto de conexión

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el juego de caracteres (opcional pero recomendado)
$conn->set_charset("utf8");
?>
