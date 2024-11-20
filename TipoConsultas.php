<?php
session_start();
include('includes/db_connect.php');
include('includes/permisos.php');

// Verificar si el usuario tiene permiso para gestionar tipos de consulta
if (!tienePermiso('Crear permisos')) {
    echo '<p style="color: red;">No tienes permiso para acceder a esta sección.</p>';
    exit();
}

// Inicializar la variable $nombre_usuario y $apellido_usuario
$nombre_usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado';

// Procesar el formulario para agregar tipos de consulta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_tipo'])) {
    $nombre_tipo = trim($_POST['nombre_tipo']);

    if (empty($nombre_tipo)) {
        $error = "El nombre del tipo de consulta no puede estar vacío.";
    } else {
        $query = "INSERT INTO tipos_consulta (nombre) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nombre_tipo);

        if ($stmt->execute()) {
            $success = "Tipo de consulta agregado exitosamente.";
        } else {
            $error = "Error al agregar el tipo de consulta. Por favor, inténtalo nuevamente.";
        }
        $stmt->close();
    }
}

// Cargar tipos de consulta predefinidos en Chile, si no están registrados
$tipos_predefinidos = [
    "Consulta General",
    "Consulta de Especialidad",
    "Consulta Pediátrica",
    "Consulta de Ginecología",
    "Consulta de Obstetricia",
    "Consulta de Traumatología",
    "Consulta Psiquiátrica",
    "Consulta de Cardiología",
    "Consulta de Dermatología",
    "Consulta de Neurología",
    "Consulta Oftalmológica",
    "Consulta de Otorrinolaringología",
    "Consulta de Gastroenterología",
    "Consulta de Urología",
    "Consulta de Nefrología",
    "Consulta de Endocrinología",
    "Consulta de Medicina Interna",
    "Consulta de Reumatología",
    "Consulta de Infectología",
    "Consulta Oncológica"
];

foreach ($tipos_predefinidos as $tipo) {
    $query = "SELECT COUNT(*) AS total FROM tipos_consulta WHERE nombre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if ($result['total'] == 0) {
        $insert_query = "INSERT INTO tipos_consulta (nombre) VALUES (?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("s", $tipo);
        $insert_stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de Consultas</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <?php include('navegacion.php'); ?>
        </aside>
        <div class="content">
            <h3>Gestión de Tipos de Consultas</h3>

            <?php if (isset($success)): ?>
                <div class="mensaje success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="mensaje error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" id="formCrearTipoConsulta">
                <label for="nombre_tipo">Nombre del Tipo de Consulta:</label>
                <input type="text" id="nombre_tipo" name="nombre_tipo" placeholder="Ejemplo: Consulta General, Pediatría" required>
                <button type="submit" class="btn-guardar">Agregar Tipo de Consulta</button>
            </form>

            <hr>

            <h3>Tipos de Consulta Registrados</h3>
            <table id="tablaTiposConsulta">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM tipos_consulta ORDER BY nombre ASC");
                    if ($result->num_rows > 0) {
                        while ($tipo = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$tipo['id']}</td>
                                    <td>{$tipo['nombre']}</td>
                                    <td>
                                        <button class='btn-eliminar' onclick='eliminarTipoConsulta({$tipo['id']})'>Eliminar</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No hay tipos de consulta registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function eliminarTipoConsulta(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este tipo de consulta?')) {
                fetch(`tipo_consulta_eliminar.php?id=${id}`, { method: 'POST' })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error al eliminar tipo de consulta:', error));
            }
        }
    </script>
</body>
</html>
