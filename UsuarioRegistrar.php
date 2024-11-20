<?php
include('includes/db_connect.php');

// Verificar si se recibieron todos los campos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $run = $_POST['run'] ;
    $nombre = $_POST['nombre'] ;
    $apellido_paterno = $_POST['apellido_paterno'] ;
    $apellido_materno = $_POST['apellido_materno'] ;
    $email = $_POST['email'] ;
    $password = $_POST['password'] ;
    $rol = $_POST['rol'] ;

    if (!$run || !$nombre || !$apellido_paterno || !$apellido_materno || !$email || !$password || !$rol) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Verificar si el RUN ya está registrado
    $query = "SELECT * FROM usuarios WHERE run = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $run);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "El RUN ya está registrado.";
        exit;
    }

    // Insertar el nuevo usuario
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO usuarios (run, nombre, apellido_paterno, apellido_materno, email, password, rol) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $run, $nombre, $apellido_paterno, $apellido_materno, $email, $hashed_password, $rol);

    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar usuario.";
    }
}
?>

