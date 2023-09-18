<?php
$servername = "localhost";
$username = "root";
$password = "";
$port = 3307; 
$dbname = "biblioteca_ejercicios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
?>
