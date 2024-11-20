<?php
include('includes/db_connect.php');

// Verificar si se recibieron los datos necesarios
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $run = $_POST['run'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    // Actualizar el usuario en la base de datos
    $query = "UPDATE usuarios SET run = ?, nombre = ?, apellido_paterno = ?, apellido_materno = ?, email = ?, rol = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssi', $run, $nombre, $apellido_paterno, $apellido_materno, $email, $rol, $id);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }
} else {
    echo "Datos incompletos.";
}
?>


