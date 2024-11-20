<?php
include('includes/db_connect.php'); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_rol = trim($_POST['nombre_rol']);

    if (!empty($nombre_rol)) {
        $stmt = $conn->prepare("INSERT INTO roles (nombre) VALUES (?)");
        $stmt->bind_param('s', $nombre_rol);

        if ($stmt->execute()) {
            echo "Rol creado exitosamente.";
        } else {
            echo "Error al crear el rol.";
        }
        $stmt->close();
    } else {
        echo "El nombre del rol no puede estar vacío.";
    }
} else {
    echo "Método no permitido.";
}
?>
