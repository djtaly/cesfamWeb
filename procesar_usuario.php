<?php
include('includes/db_connect.php');

// Verificar si los datos fueron enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $run = preg_replace('/[^0-9]/', '', $_POST['run']);
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $selectRolesNuevoUsuario= $_POST['rol'];

    $query = "INSERT INTO usuarios (run, nombre, apellido_paterno, apellido_materno, email, password, rol) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $run, $nombre, $apellido_paterno, $apellido_materno, $email, $password, $rol);

    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente";
    } else {
        echo "Error al registrar usuario";
    }
}
?>


