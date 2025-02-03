<?php
// Conexión a la base de datos
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Insertar el nuevo registro en la base de datos
    $sql = "INSERT INTO users (document, firstName, lastName, phone, address) VALUES ('$codigo', '$nombre', '$apellidos', '$telefono', '$direccion')";

    if ($conn->query($sql) === TRUE) {
        // Si la inserción fue exitosa, cargar los datos actualizados
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['codigo']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['apellidos']}</td>
                        <td>{$row['telefono']}</td>
                        <td>{$row['direccion']}</td>
                        <td>
                            <button class='btn btn-warning btn-sm' onclick='editarRegistro({$row['codigo']}, \"{$row['nombre']}\", \"{$row['apellidos']}\", \"{$row['telefono']}\", \"{$row['direccion']}\")'>Editar</button>
                            <button class='btn btn-danger btn-sm' onclick='eliminarRegistro({$row['codigo']})'>Eliminar</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay registros.</td></tr>";
        }
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}
?>
