<?php
include('includes/db_connect.php'); // Conexión a la base de datos

$result = $conn->query("SELECT * FROM permisos");

while ($permiso = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$permiso['id']}</td>
            <td>{$permiso['nombre']}</td>
            <td>
                <button class='btn-eliminar' onclick='eliminarPermiso({$permiso['id']})'>Eliminar</button>
            </td>
          </tr>";
}
?>
