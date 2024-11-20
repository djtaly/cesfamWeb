<?php
session_start();
include('includes/db_connect.php');
include('includes/permisos.php');

// Verificar si el usuario tiene permiso para crear permisos
if (!tienePermiso('Crear permisos')) {
    echo '<p style="color: red;">No tienes permiso para acceder a esta sección.</p>';
    exit();
}

// Procesar el formulario de creación de permisos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_permiso = trim($_POST['nombre_permiso']);

    if (empty($nombre_permiso)) {
        $error = "El nombre del permiso no puede estar vacío.";
    } else {
        $query = "INSERT INTO permisos (nombre) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nombre_permiso);

        if ($stmt->execute()) {
            $success = "Permiso creado exitosamente.";
        } else {
            $error = "Error al crear el permiso. Por favor, inténtalo de nuevo.";
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
    <title>Crear Permisos</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <?php include('navegacion.php'); ?>
        </aside>
        <div class="content">
            <h3>Crear Permisos</h3>

            <?php if (isset($success)): ?>
                <div class="mensaje success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="mensaje error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" id="formCrearPermiso">
                <label for="nombre_permiso">Nombre del Permiso:</label>
                <input type="text" id="nombre_permiso" name="nombre_permiso" placeholder="Ejemplo: Registrar pacientes, Ver exámenes" required>
                <button type="submit" class="btn-guardar">Crear Permiso</button>
            </form>

            <hr>

            <h3>Permisos Existentes</h3>
            <table id="tablaPermisos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM permisos");
                    if ($result->num_rows > 0) {
                        while ($permiso = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$permiso['id']}</td>
                                    <td>{$permiso['nombre']}</td>
                                    <td>
                                        <button class='btn-eliminar' onclick='eliminarPermiso({$permiso['id']})'>Eliminar</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No hay permisos registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function eliminarPermiso(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este permiso?')) {
                fetch(`permiso_eliminar.php?id=${id}`, { method: 'POST' })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error al eliminar permiso:', error));
            }
        }
    </script>
</body>
</html>
