<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $genero = $_POST['genero'];
    $empresa = $_POST['empresa'] ?? null;

    // Insertar nuevo videojuego en la base de datos
    $query = "INSERT INTO Videojuegos (Nombre, Descripcion, Genero, Empresa) VALUES ('$nombre', '$descripcion', '$genero', '$empresa')";
    if (mysqli_query($conn, $query)) {
        header("Location: videojuegos.php");
    } else {
        echo "Error al agregar el videojuego: " . mysqli_error($conn);
    }
}
?>
