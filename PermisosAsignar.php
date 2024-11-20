<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rol_id = isset($_POST['rol_id']) ? intval($_POST['rol_id']) : null;
    $permiso_id = isset($_POST['permiso_id']) ? intval($_POST['permiso_id']) : null;

    // Verificar que ambos valores sean válidos
    if (!$rol_id || !$permiso_id) {
        echo json_encode(['status' => 'error', 'message' => 'Rol y Permiso son obligatorios.']);
        exit();
    }

    // Verificar si ya existe la asignación
    $query = "SELECT * FROM rol_permiso WHERE rol_id = ? AND permiso_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $rol_id, $permiso_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Este permiso ya está asignado a este rol.']);
        exit();
    }

    // Insertar la nueva asignación
    $query = "INSERT INTO rol_permiso (rol_id, permiso_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $rol_id, $permiso_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Permiso asignado correctamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al asignar el permiso.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}
?>

