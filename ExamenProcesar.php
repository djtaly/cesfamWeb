<?php
include('includes/db_connect.php');

if (isset($_POST['paciente_id']) && isset($_FILES['archivo'])) {
    $paciente_id = (int) $_POST['paciente_id'];
    $archivo = $_FILES['archivo'];

    // Consultar los datos del paciente
    $queryPaciente = "SELECT run, nombre, apellido_paterno, apellido_materno FROM pacientes WHERE id = ?";
    $stmt = $conn->prepare($queryPaciente);
    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $paciente = $result->fetch_assoc();

        // Crear el nombre del archivo basado en los datos del paciente
        $run = preg_replace('/[^a-zA-Z0-9]/', '_', $paciente['run']); // Sanear el RUN
        $nombre = preg_replace('/[^a-zA-Z0-9]/', '_', $paciente['nombre']); // Sanear el nombre
        $apellido_paterno = preg_replace('/[^a-zA-Z0-9]/', '_', $paciente['apellido_paterno']); // Sanear el apellido paterno
        $apellido_materno = preg_replace('/[^a-zA-Z0-9]/', '_', $paciente['apellido_materno']); // Sanear el apellido materno

        $nombreArchivo = "{$run}_{$nombre}_{$apellido_paterno}_{$apellido_materno}_" . time() . ".pdf";
        $rutaDestino = 'uploads/' . $nombreArchivo;

        // Mover el archivo al destino con el nuevo nombre
        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            // Guardar los datos en la base de datos
            $sql = "INSERT INTO examenes (paciente_id, archivo) VALUES (?, ?)";
            $stmtInsert = $conn->prepare($sql);
            $stmtInsert->bind_param("is", $paciente_id, $nombreArchivo);

            if ($stmtInsert->execute()) {
                echo "Examen subido exitosamente.";
            } else {
                echo "Error al guardar el examen en la base de datos: " . $conn->error;
            }
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "Paciente no encontrado.";
    }
} else {
    echo "Datos incompletos.";
}

$conn->close();
?>
