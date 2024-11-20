<?php
include('includes/db_connect.php'); // Conexión a la base de datos

$result = $conn->query("SELECT * FROM tipos_consulta");

while ($consulta = $result->fetch_assoc()) {
    echo "<tr data-id='{$consulta['id']}'>
            <td>{$consulta['id']}</td>
            <td>{$consulta['nombre']}</td>
            <td>
                <button class='btn-eliminar' onclick='eliminarConsulta({$consulta['id']})'>Eliminar</button>
            </td>
          </tr>";
}

$conn->close();
?>
