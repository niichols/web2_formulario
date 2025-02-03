<?php
// Incluir la conexión a la base de datos
include 'connect.php';

// Verificar si se pasa un parámetro 'codigo' desde la URL
if (isset($_GET['codigo'])) {
    // Preparar la consulta SQL para evitar SQL Injection
    $codigo = $_GET['codigo'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE document = ?");
    $stmt->bind_param("s", $codigo); // 's' para string
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Si no se pasa un código, mostrar todos los registros
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo"<tr>
                <td>{$row['document']}</td>
                <td>{$row['firstName']}</td>
                <td>{$row['lastName']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['address']}</td>
                <td>
                    <button class='btn btn-warning btn-sm' onclick='editarRegistro({$row['document']}, \"{$row['firstName']}\", \"{$row['lastName']}\", \"{$row['phone']}\", \"{$row['address']}\")'>Editar</button>
                    <button class='btn btn-danger btn-sm' onclick='eliminarRegistro({$row['document']})'>Eliminar</button>
                    </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay registros.</td></tr>";
}

$conn->close();
?>
