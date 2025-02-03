<?php
// Datos de la conexión
$host = "localhost";
$username = "root";
$password = "";
$database = "gestion";

// Crear la conexión
$conn = new mysqli($host, $username, $password, $database);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    echo("La conexión a la base de datos falló: " . $conn->connect_error);
}
// echo "Conexión exitosa a la base de datos!";
?>
