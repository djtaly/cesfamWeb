<?php
include('includes/db_connect.php');

// Verificar si la ID está presente en la URL
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Preparar la consulta SQL para eliminar al usuario por ID
    $query = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $usuario_id);

    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID del usuario no proporcionada.";
}
?>

