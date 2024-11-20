<?php
include('includes/db_connect.php'); // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM tipos_consultas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Consulta eliminada exitosamente.";
    } else {
        echo "Error al eliminar la consulta.";
    }

    $stmt->close();
    $conn->close();
}
?>
