<?php
include('includes/db_connect.php');

// Verificar si se envió un ID válido por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Consulta para obtener los datos del paciente por ID
    $query = "SELECT id, run, nombre, apellido_paterno, apellido_materno, fecha_nacimiento
              FROM pacientes
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Convertir los datos del paciente en un JSON para enviarlos al frontend
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Paciente no encontrado.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID no válido.']);
}
?>
