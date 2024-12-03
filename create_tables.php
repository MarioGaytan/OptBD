<?php
include 'conexion.php';

$sql = "
CREATE TABLE Usuarios (
    Id_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL UNIQUE,
    Contraseña VARCHAR(255) NOT NULL
);

CREATE TABLE Videojuegos (
    Id_Videojuego INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT NOT NULL,
    Genero VARCHAR(50) NOT NULL,
    Empresa VARCHAR(50)
);

CREATE TABLE Biblioteca (
    Id_Biblioteca INT AUTO_INCREMENT PRIMARY KEY,
    Id_Usuario INT NOT NULL,
    Id_Videojuego INT NOT NULL,
    Fecha_de_juego DATE,
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (Id_Videojuego) REFERENCES Videojuegos(Id_Videojuego)
);
";

if ($conn->multi_query($sql)) {
    echo "Tablas creadas exitosamente.";
} else {
    echo "Error al crear las tablas: " . $conn->error;
}

$conn->close();
?>
