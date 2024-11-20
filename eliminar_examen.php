<?php
include('includes/db_connect.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM examenes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Examen eliminado exitosamente.";
    } else {
        echo "Error al eliminar el examen: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
