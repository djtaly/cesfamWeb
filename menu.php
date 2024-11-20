<?php
session_start();
include('includes/db_connect.php');
include('includes/permisos.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Datos de sesión
$rol = $_SESSION['rol'];
$nombre_usuario = $_SESSION['nombre'];

$fecha_ingreso = date("d/m/Y H:i:s");

// Cargar permisos si aún no están en la sesión
if (!isset($_SESSION['permisos'])) {
    $_SESSION['permisos'] = obtenerPermisosPorRol($rol);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include('navegacion.php'); ?>
    <div class="content">
        <h1>Bienvenido al sistema, <?php echo htmlspecialchars($nombre_usuario); ?></h1>
    </div>
</body>
</html>
