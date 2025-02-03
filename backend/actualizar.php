<?php
// Incluir la conexión a la base de datos
include 'connect.php';

// Verificar si los parámetros de la URL y el POST están siendo recibidos correctamente
// var_dump($_GET); // Muestra los parámetros de la URL
// var_dump($_POST); // Muestra los datos enviados a través de POST

if (isset($_GET['codigo']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['phone']) && isset($_POST['address'])) {
    $codigo = $_GET['codigo'];
    $nombre = $_POST['firstName'];
    $apellidos = $_POST['lastName'];
    $telefono = $_POST['phone'];
    $direccion = $_POST['address'];

    // Consulta SQL para actualizar el registro
    $sql = "UPDATE users SET firstName='$nombre', lastName='$apellidos', phone='$telefono', address='$direccion' WHERE document='$codigo'";

    if ($conn->query($sql) === TRUE) {
        echo "Registro actualizado correctamente";
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
} else {
    echo "Faltan datos necesarios para la actualización.";
}

$conn->close();
?>
