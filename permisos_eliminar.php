<?php
include('includes/db_connect.php'); // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir a entero para evitar inyecciones SQL

    $stmt = $conn->prepare("DELETE FROM permisos WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "Permiso eliminado exitosamente.";
    } else {
        echo "Error al eliminar el permiso.";
    }

    $stmt->close();
} else {
    echo "ID de permiso no especificado.";
}
?>
