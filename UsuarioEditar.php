<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $run = $_POST['run'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $apellido_paterno = $_POST['apellido_paterno'] ?? null;
    $apellido_materno = $_POST['apellido_materno'] ?? null;
    $email = $_POST['email'] ?? null;
    $rol = $_POST['rol'] ?? null;

    if (!$id || !$run || !$nombre || !$apellido_paterno || !$email || !$rol) {
        echo 'Faltan campos obligatorios.';
        exit();
    }

    try {
        $query = "UPDATE usuarios 
                  SET run = ?, nombre = ?, apellido_paterno = ?, apellido_materno = ?, email = ?, rol = ? 
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssssi', $run, $nombre, $apellido_paterno, $apellido_materno, $email, $rol, $id);

        if ($stmt->execute()) {
            echo 'Usuario actualizado exitosamente.';
        } else {
            throw new Exception('Error al actualizar el usuario.');
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
    }
}
?>

