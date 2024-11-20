<?php
include('includes/db_connect.php'); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_consulta'];

    // Preparar e insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO tipos_consultas (nombre) VALUES (?)");
    $stmt->bind_param("s", $nombre);

    if ($stmt->execute()) {
        echo "Consulta creada exitosamente.";
    } else {
        echo "Error al crear la consulta.";
    }

    $stmt->close();
    $conn->close();
}
?>
