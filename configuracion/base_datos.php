<?php
<<<<<<< HEAD
$servername = "127.0.0.1";  // El servidor de MySQL (localhost cuando usas XAMPP)
$username = "root";         // El nombre de usuario (por defecto, en XAMPP es "root")
$password = "";             // La contraseña (por defecto, en XAMPP no hay contraseña)
$dbname = "bdhotel";        // Nombre correcto de tu base de datos
=======
$servername = "localhost"; 
$username = "root";         
$password = "";          
$dbname = "bdhotel";      
>>>>>>> 78e0481c3bc52e30effb354161a3e47a4c503d49

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el juego de caracteres
$conn->set_charset("utf8mb4");
?>