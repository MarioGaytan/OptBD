<?php
session_start();

if (!isset($_SESSION['Id_Usuario']) || !($_SESSION['Es_Admin'] ?? false)) {
    header("Location: index.html");
    exit();
}

require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $genero = $_POST['genero'];
    $empresa = $_POST['empresa'];

    $query = "INSERT INTO Videojuegos (Nombre, Descripcion, Genero, Empresa) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $descripcion, $genero, $empresa);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: videojuegos.php");
    } else {
        echo "Error al guardar el videojuego: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
