<?php
include('includes/permisos.php');
include('includes/db_connect.php');

// Verificar si el usuario tiene permiso para gestionar permisos
verificarPermiso('Gestion Permisos');

// Verificar si se ha enviado la solicitud POST con el ID de la relación rol-permiso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegurarse de que se reciba el ID de la relación rol-permiso
    if (!isset($_POST['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID de permiso no proporcionado.']);
        exit();
    }

    $id = intval($_POST['id']); // Convertir el ID a entero para mayor seguridad

    // Preparar la consulta para eliminar la relación entre el rol y el permiso
    $query = "DELETE FROM rol_permiso WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta.']);
        exit();
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Permiso eliminado correctamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el permiso: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
    exit();
}
