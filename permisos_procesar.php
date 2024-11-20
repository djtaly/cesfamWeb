<?php
include('includes/db_connect.php'); // Conexión a la base de datos

if (isset($_POST['nombre_permiso'])) {
    $nombre_permiso = $_POST['nombre_permiso'];

    $stmt = $conn->prepare("INSERT INTO permisos (nombre) VALUES (?)");
    $stmt->bind_param('s', $nombre_permiso);

    if ($stmt->execute()) {
        echo "Permiso creado exitosamente.";
    } else {
        echo "Error al crear el permiso.";
    }

    $stmt->close();
} else {
    echo "Datos del permiso no recibidos.";
}
?>
