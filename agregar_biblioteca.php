<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: index.html");
    exit();
}

$id_usuario = $_SESSION['Id_Usuario'];
$id_videojuego = $_GET['id'] ?? null; // Obtener el ID del videojuego desde el parámetro URL

// Verificar si el ID del videojuego es válido
if (!$id_videojuego) {
    echo "Videojuego no válido.";
    exit();
}

// Si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_juego = !empty($_POST['fecha']) ? $_POST['fecha'] : null; // Fecha es opcional

    // Verificar si el juego ya está en la biblioteca
    $check_query = "SELECT 1 FROM Biblioteca WHERE Id_Usuario = ? AND Id_Videojuego = ?";
    $stmt_check = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt_check, "ii", $id_usuario, $id_videojuego);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        echo "Este juego ya está en tu biblioteca.";
    } else {
        // Insertar en la tabla Biblioteca
        $insert_query = "INSERT INTO Biblioteca (Id_Usuario, Id_Videojuego, Fecha_de_juego) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt_insert, "iis", $id_usuario, $id_videojuego, $fecha_juego);

        if (mysqli_stmt_execute($stmt_insert)) {
            echo "Videojuego agregado exitosamente a tu biblioteca.";
        } else {
            echo "Error al agregar el videojuego: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_stmt_close($stmt_check);
    mysqli_close($conn);
    
    // Redirigir de vuelta a la biblioteca después de agregar
    header("Location: biblioteca.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar a Biblioteca - Xbox Library</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Videojuego a tu Biblioteca</h1>
        <form method="POST" class="formulario">
            <label for="fecha">Fecha de juego (opcional):</label>
            <input type="date" id="fecha" name="fecha" class="input-fecha">
            
            <div class="botones-container">
                <button type="submit" class="boton">Confirmar Agregar</button>
                <a href="videojuegos.php" class="boton-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
