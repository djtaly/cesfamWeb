<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['run'])) {
    $run = preg_replace('/[^0-9]/', '', $_GET['run']); // Limpiar el RUN

    $query = "SELECT id, run, nombre, apellido_paterno, apellido_materno, fecha_nacimiento,
                     TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad
              FROM pacientes
              WHERE run = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $run);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Paciente no encontrado.']);
    }
} else {
    echo json_encode(['error' => 'Parámetro RUN no válido.']);
}
?>

