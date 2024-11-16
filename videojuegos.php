<?php
session_start();

if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: index.html");
    exit();
}

require_once 'conexion.php';

function escapar($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

$search = $_GET['search'] ?? '';
$query = "SELECT * FROM Videojuegos WHERE Nombre LIKE ? ORDER BY Nombre ASC";
$stmt = mysqli_prepare($conn, $query);
$search_param = '%' . $search . '%';
mysqli_stmt_bind_param($stmt, "s", $search_param);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$num_juegos = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Todos los Videojuegos - Xbox Library</title>
    <link rel="stylesheet" href="assets/videojuegos-styles.css">
</head>
<body>
    <div class="games-header">
        <h1>Lista de Videojuegos</h1>
        <p>Bienvenido, <?php echo escapar($_SESSION['Nombre']); ?></p>
    </div>

    <form method="GET" action="videojuegos.php" class="search-form">
        <input type="text" name="search" placeholder="Buscar videojuego..." value="<?php echo escapar($search); ?>">
        <button type="submit" class="search-button">Buscar</button>
    </form>

    <div class="games-container">
        <?php if ($num_juegos > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="game-card">
                    <h3><?php echo escapar($row['Nombre']); ?></h3>
                    <p><?php echo escapar($row['Descripcion']); ?></p>
                    <p><strong>Género:</strong> <?php echo escapar($row['Genero']); ?></p>
                    <p><strong>Empresa:</strong> <?php echo escapar($row['Empresa']); ?></p>
                    <a href="agregar_biblioteca.php?id=<?php echo $row['Id_Videojuego']; ?>" class="add-to-library-button">Agregar a Biblioteca</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-games-message">
                <p>No hay videojuegos disponibles.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="action-buttons">
        <a href="biblioteca.php" class="action-button">Volver a Biblioteca</a>
        <button onclick="mostrarFormulario()" class="action-button">Agregar Nuevo Videojuego</button>
        <a href="logout.php" class="logout-button">Cerrar Sesión</a>
    </div>

    <div id="formularioModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2>Agregar Nuevo Videojuego</h2>
            <form action="agregar_videojuego.php" method="POST">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
                <label>Descripción:</label>
                <textarea name="descripcion" required></textarea>
                <label>Género:</label>
                <input type="text" name="genero" required>
                <label>Empresa:</label>
                <input type="text" name="empresa">
                <button type="submit" class="action-button">Guardar</button>
                <button type="button" onclick="cerrarFormulario()" class="cancel-button">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        function mostrarFormulario() {
            document.getElementById('formularioModal').style.display = 'block';
        }
        function cerrarFormulario() {
            document.getElementById('formularioModal').style.display = 'none';
        }
    </script>

    <?php
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    ?>
</body>
</html>
