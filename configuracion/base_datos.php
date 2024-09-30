<?php
$servername = "localhost"; 
$username = "root";         
$password = "";          
$dbname = "bdhotel";      

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el juego de caracteres
$conn->set_charset("utf8mb4");
?>
