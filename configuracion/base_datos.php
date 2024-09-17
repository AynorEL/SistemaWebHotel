<?php
$servername = "localhost";  // El servidor de MySQL (localhost cuando usas XAMPP)
$username = "root";         // El nombre de usuario (por defecto, en XAMPP es "root")
$password = "";             // La contraseña (por defecto, en XAMPP no hay contraseña)
$dbname = "dbhotel";        // Nombre correcto de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el juego de caracteres
$conn->set_charset("utf8mb4");
?>
