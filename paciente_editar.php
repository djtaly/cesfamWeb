<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $run = preg_replace('/[^0-9]/', '', $_POST['run']); // Limpiar el RUN
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Verificar si el RUN ya está asignado a otro paciente
    $query = "SELECT * FROM pacientes WHERE run = ? AND id != ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $run, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: El RUN ya está asignado a otro paciente.";
    } else {
        // Actualizar los datos del paciente
        $query = "UPDATE pacientes SET run = ?, nombre = ?, apellido_paterno = ?, apellido_materno = ?, fecha_nacimiento = ?
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $run, $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $id);

        if ($stmt->execute()) {
            echo "Paciente actualizado exitosamente.";
        } else {
            echo "Error al actualizar los datos del paciente.";
        }
    }
}
?>


