<?php
include('includes/db_connect.php');

// Consulta para obtener los usuarios
$query = "SELECT u.id, u.run, u.nombre, u.apellido_paterno, u.apellido_materno, u.email, r.nombre AS rol 
          FROM usuarios u 
          JOIN roles r ON u.rol = r.id";
$result = $conn->query($query);

$usuarios = [];
while ($usuario = $result->fetch_assoc()) {
    $usuarios[] = $usuario;
}

// Retornar los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($usuarios);
?>



