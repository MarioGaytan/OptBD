<?php
// conexion.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "xbox_library";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el juego de caracteres (opcional pero recomendado)
$conn->set_charset("utf8");
?>
