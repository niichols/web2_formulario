<?php
// Conexión a la base de datos
include 'connect.php';

// Consultar todos los registros
$sql = "SELECT * FROM users"; // Cambia la tabla aquí si es necesario
$result = $conn->query($sql);

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
