<?php
include('includes/db_connect.php');

// Consulta para obtener los pacientes y calcular la edad
$query = "
    SELECT id, run, nombre, apellido_paterno, apellido_materno, fecha_nacimiento,
           TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad
    FROM pacientes
";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['run']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['apellido_paterno']}</td>
                <td>{$row['apellido_materno']}</td>
                <td>{$row['fecha_nacimiento']}</td>
                <td>{$row['edad']}</td>
                <td>
                    <button onclick=\"abrirModalEditarPaciente({$row['id']})\">Editar</button>
                    <button onclick=\"eliminarPaciente({$row['id']})\">Eliminar</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hay pacientes registrados.</td></tr>";
}
?>






