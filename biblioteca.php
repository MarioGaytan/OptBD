<?php
session_start();

// Verificar si existe la sesión usando Id_Usuario
if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: index.html");
    exit();
}

require_once 'conexion.php';

$id_usuario = $_SESSION['Id_Usuario'];

// Consulta segura con prepared statements
$query = "SELECT v.Nombre, v.Descripcion, v.Genero, v.Empresa, b.Fecha_de_juego 
          FROM Biblioteca b 
          JOIN Videojuegos v ON b.Id_Videojuego = v.Id_Videojuego 
          WHERE b.Id_Usuario = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$num_juegos = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca - Xbox Library</title>
    <link rel="stylesheet" href="assets/biblioteca-styles.css">
</head>
<body>
    <div class="library-header">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['Nombre']); ?></h1>
        <h2>Tu Biblioteca de Videojuegos</h2>
    </div>

    <div class="library-container">
        <?php if ($num_juegos > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="game-card">
                    <div class="game-card-content">
                        <h3><?php echo htmlspecialchars($row['Nombre']); ?></h3>
                        <p class="game-description"><?php echo htmlspecialchars($row['Descripcion']); ?></p>
                        <p><strong>Género:</strong> <?php echo htmlspecialchars($row['Genero']); ?></p>
                        <p><strong>Empresa:</strong> <?php echo htmlspecialchars($row['Empresa']) ?: 'No especificada'; ?></p>
                        <p><strong>Fecha de juego:</strong> <?php echo $row['Fecha_de_juego'] ? htmlspecialchars($row['Fecha_de_juego']) : 'No especificada'; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-message">
                <p>Tu biblioteca está vacía. ¡Comienza a agregar juegos!</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="library-buttons">
        <a href="videojuegos.php" class="button">Ver Todos los Videojuegos</a>
        <a href="logout.php" class="button-logout">Cerrar Sesión</a>
    </div>

    <?php
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    ?>
</body>
</html>
