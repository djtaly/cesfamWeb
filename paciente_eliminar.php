<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el ID del paciente fue enviado
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);

        // Consulta para eliminar al paciente
        $query = "DELETE FROM pacientes WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Paciente eliminado exitosamente.";
        } else {
            echo "Error al eliminar el paciente.";
        }

        $stmt->close();
    } else {
        echo "ID de paciente no válido.";
    }
} else {
    echo "Método no permitido.";
}
?>
