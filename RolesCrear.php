<?php
session_start();
include('includes/db_connect.php');
include('includes/permisos.php');

// Verificar si el usuario tiene permiso para crear roles
if (!tienePermiso('Crear roles')) {
    echo '<p style="color: red;">No tienes permiso para acceder a esta sección.</p>';
    exit();
}

// Inicializar la variable $nombre_usuario y $apellido_usuario
$nombre_usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado';
$apellido_usuario = isset($_SESSION['apellido_paterno']) ? $_SESSION['apellido_paterno'] : '';

// Procesar el formulario de creación de roles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_rol = trim($_POST['nombre_rol']);

    if (empty($nombre_rol)) {
        $error = "El nombre del rol no puede estar vacío.";
    } else {
        $query = "INSERT INTO roles (nombre) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nombre_rol);

        if ($stmt->execute()) {
            $success = "Rol creado exitosamente.";
        } else {
            $error = "Error al crear el rol. Por favor, inténtalo de nuevo.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Roles</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <?php include('navegacion.php'); ?>
        </aside>
        <div class="content">
            <h3>Crear Roles</h3>

            <?php if (isset($success)): ?>
                <div class="mensaje success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="mensaje error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" id="formCrearRol">
                <label for="nombre_rol">Nombre del Rol:</label>
                <input type="text" id="nombre_rol" name="nombre_rol" placeholder="Ejemplo: Médico, Paciente, Administrador" required>
                <button type="submit" class="btn-guardar">Crear Rol</button>
            </form>

            <hr>

            <h3>Roles Existentes</h3>
            <table id="tablaRoles">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM roles");
                    if ($result->num_rows > 0) {
                        while ($rol = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$rol['id']}</td>
                                    <td>{$rol['nombre']}</td>
                                    <td>
                                        <button class='btn-eliminar' onclick='eliminarRol({$rol['id']})'>Eliminar</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No hay roles registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function eliminarRol(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este rol?')) {
                fetch(`rol_eliminar.php?id=${id}`, { method: 'POST' })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error al eliminar rol:', error));
            }
        }
    </script>
</body>
</html>
