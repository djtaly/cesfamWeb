<?php
session_start();
include('includes/db_connect.php');
include('includes/permisos.php');

// Verificar si el usuario tiene permiso para gestionar usuarios
if (!tienePermiso('Gestionar usuarios')) {
    echo '<p style="color: red;">No tienes permiso para acceder a esta sección.</p>';
    exit();
}
// Inicializar la variable $nombre_usuario y $apellido_usuario
$nombre_usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado';
$apellido_usuario = isset($_SESSION['apellido_paterno']) ? $_SESSION['apellido_paterno'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <?php include('navegacion.php'); ?>
        </aside>
        <main class="content">
            <h3>Gestión de Usuarios</h3>
            <button class="btn-agregar" onclick="abrirModalNuevoUsuario()">Agregar Nuevo Usuario</button>

            <table id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>RUN</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los usuarios se cargarán dinámicamente aquí -->
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal: Nuevo Usuario -->
    <div id="modalNuevoUsuario" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal('modalNuevoUsuario')">&times;</span>
            <h3>Agregar Nuevo Usuario</h3>
            <form id="formNuevoUsuario">
                <input type="text" name="run" placeholder="RUN (sin puntos ni guiones)" required>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="text" name="apellido_paterno" placeholder="Apellido Paterno" required>
                <input type="text" name="apellido_materno" placeholder="Apellido Materno" required>
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <select id="selectRolesNuevoUsuario" name="rol" required>
                    <option value="" disabled selected>Cargando roles...</option>
                </select>
                <button type="submit" class="btn-guardar">Registrar Usuario</button>
            </form>
        </div>
    </div>

    <!-- Modal: Editar Usuario -->
    <div id="modalEditarUsuario" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal('modalEditarUsuario')">&times;</span>
            <h3>Editar Usuario</h3>
            <form id="formEditarUsuario">
                <input type="hidden" id="usuario-id" name="id">
                <input type="text" id="usuario-run" name="run" placeholder="RUN (sin puntos ni guiones)" required>
                <input type="text" id="usuario-nombre" name="nombre" placeholder="Nombre" required>
                <input type="text" id="usuario-apellido-paterno" name="apellido_paterno" placeholder="Apellido Paterno" required>
                <input type="text" id="usuario-apellido-materno" name="apellido_materno" placeholder="Apellido Materno" required>
                <input type="email" id="usuario-email" name="email" placeholder="Correo Electrónico" required>
                <select id="selectRolesEditarUsuario" name="rol" required>
                    <option value="" disabled selected>Cargando roles...</option>
                </select>
                <button type="submit" class="btn-guardar">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script src="js/usuariosGestion.js"></script>
</body>
</html>


