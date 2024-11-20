<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $run = preg_replace('/[^0-9]/', '', $_POST['run']); // Limpiar el RUN
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar si el RUN ya existe
    $query = "SELECT * FROM pacientes WHERE run = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $run);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: El RUN ya está registrado.";
    } else {
        // Registrar al paciente
        $query = "INSERT INTO pacientes (run, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, password)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $run, $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $password);

        if ($stmt->execute()) {
            echo "Paciente registrado exitosamente.";
        } else {
            echo "Error al registrar al paciente.";
        }
    }
}
?>


