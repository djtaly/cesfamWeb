<?php
include('includes/db_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $run = preg_replace('/[^0-9]/', '', $_POST['run']); // Eliminar puntos y guiones del RUN
    $password = $_POST['password'];

   $queryUsuario = "
    SELECT usuarios.*, roles.nombre AS rol_nombre
    FROM usuarios
    JOIN roles ON usuarios.rol = roles.id
    WHERE usuarios.run = ?
";
$stmtUsuario = $conn->prepare($queryUsuario);
$stmtUsuario->bind_param("s", $run);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();

if ($resultUsuario->num_rows === 1) {
    // Usuario encontrado
    $user = $resultUsuario->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Iniciar sesión como usuario
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['rol'] = $user['rol']; // ID del rol
        $_SESSION['rol_nombre'] = $user['rol_nombre']; // Nombre del rol
        $_SESSION['nombre'] = $user['nombre'];
        
        // Cargar permisos
        require_once('includes/permisos.php');
        $_SESSION['permisos'] = obtenerPermisosPorRol($user['rol']);

        header("Location: menu.php");
        exit();
    } else {
        $error = "Contraseña incorrecta.";
    }


    } else {
        // Si no es usuario, verificar si es un paciente
        $queryPaciente = "SELECT * FROM pacientes WHERE run = ?";
        $stmtPaciente = $conn->prepare($queryPaciente);
        $stmtPaciente->bind_param("s", $run);
        $stmtPaciente->execute();
        $resultPaciente = $stmtPaciente->get_result();

        if ($resultPaciente->num_rows === 1) {
            // Paciente encontrado
            $paciente = $resultPaciente->fetch_assoc();
            if (password_verify($password, $paciente['password'])) {
                // Iniciar sesión como paciente
                $_SESSION['paciente_id'] = $paciente['id'];
                $_SESSION['paciente_run'] = $paciente['run'];
                $_SESSION['paciente_nombre'] = $paciente['nombre'];

                header("Location: PacienteExamenes.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "RUN no encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="run" placeholder="RUN (sin puntos ni guiones)" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>


