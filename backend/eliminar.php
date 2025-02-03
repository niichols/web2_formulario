<?php
// Incluir la conexión a la base de datos
include 'connect.php';

if (isset($_GET['document'])) {
    // Obtener el código del registro a eliminar
    $codigo = $_GET['document'];

    // Consulta SQL para eliminar el registro
    $sql = "DELETE FROM users WHERE document = '$codigo'";

    if ($conn->query($sql) === TRUE) {
        echo "Registro eliminado correctamente";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}

$conn->close();
?>



