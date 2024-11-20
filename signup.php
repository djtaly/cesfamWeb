<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nombre, $email, $password, $rol);

    if ($stmt->execute()) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form method="POST" action="">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br>
        <label>Rol:</label>
        <select name="rol">
            <option value="administrador">Administrador</option>
            <option value="administrativo">Administrativo</option>
            <option value="medico">Médico</option>
            <option value="paciente">Paciente</option>
        </select><br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
