<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    // Verificar si el usuario ya existe
    $checkUser = $conn->prepare("SELECT * FROM Usuarios WHERE Nombre = ?");
    $checkUser->bind_param("s", $nombre);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('El usuario ya existe.'); window.location.href = 'index.html';</script>";
    } else {
        // Insertar nuevo usuario
        $stmt = $conn->prepare("INSERT INTO Usuarios (Nombre, Contraseña) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $contraseña);

        if ($stmt->execute()) {
            header("Location: biblioteca.php");
        } else {
            echo "<script>alert('Error al registrarse.'); window.location.href = 'index.html';</script>";
        }

        $stmt->close();
    }

    $checkUser->close();
}

$conn->close();
?>
