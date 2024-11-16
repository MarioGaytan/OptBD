<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Videojuego - Xbox Library</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <h1>Agregar Nuevo Videojuego</h1>

    <form action="agregar_videojuego.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="genero">Género:</label>
        <input type="text" id="genero" name="genero" required>

        <label for="empresa">Empresa (opcional):</label>
        <input type="text" id="empresa" name="empresa">

        <button type="submit">Agregar Videojuego</button>
    </form>

    <a href="videojuegos.php" class="boton">Volver a Videojuegos</a>
</body>
</html>
