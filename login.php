<?php
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    // Verificar credenciales
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE Nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($contraseña, $user['Contraseña'])) {
        $_SESSION['Id_Usuario'] = $user['Id_Usuario'];
        $_SESSION['Nombre'] = $user['Nombre'];
        header("Location: biblioteca.php");
    } else {
        echo "<script>alert('Credenciales incorrectas.'); window.location.href = 'index.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
