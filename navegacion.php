<?php
// Verificar si la sesión tiene permisos cargados
if (!isset($_SESSION['permisos'])) {
    echo '<p>Error: No se han cargado los permisos para este usuario.</p>';
    exit();
}
?>

<div class="sidebar">
    <h2><i class="fas fa-user-cog"></i> Panel de Usuario</h2>
    <p class="user-info"><i class="fas fa-user-circle"></i> Bienvenido, <?php echo htmlspecialchars("$nombre_usuario"); ?></p>
    <nav>
        <ul>
            <?php if (in_array('Registrar pacientes', $_SESSION['permisos'])): ?>
                <li><a href="PacienteRegistro.php"><i class="fas fa-user-plus"></i> Registrar Paciente</a></li>
            <?php endif; ?>

            <?php if (in_array('Subir exámenes', $_SESSION['permisos'])): ?>
                <li><a href="ExamenSubir.php"><i class="fas fa-upload"></i> Subir Exámenes</a></li>
            <?php endif; ?>

            <?php if (in_array('Revisar exámenes', $_SESSION['permisos'])): ?>
                <li><a href="ExamenRevisar.php"><i class="fas fa-folder-open"></i> Ver Exámenes</a></li>
            <?php endif; ?>

            <?php if (in_array('Gestionar usuarios', $_SESSION['permisos'])): ?>
                <li><a href="UsuariosGestion.php"><i class="fas fa-users"></i> Gestión de Usuarios</a></li>
            <?php endif; ?>

            <?php if (in_array('Configuración general', $_SESSION['permisos'])): ?>
                <li class="submenu">
                    <a href="#"><i class="fas fa-cogs"></i> Configuración <i class="fas fa-chevron-down"></i></a>
                    <ul class="submenu-content">
                        <?php if (in_array('Crear roles', $_SESSION['permisos'])): ?>
                            <li><a href="RolesCrear.php"><i class="fas fa-user-tag"></i> Crear Roles</a></li>
                        <?php endif; ?>
                        <?php if (in_array('Crear permisos', $_SESSION['permisos'])): ?>
                            <li><a href="PermisosCrear.php"><i class="fas fa-lock"></i> Crear Permisos</a></li>
                        <?php endif; ?>
						<?php if (in_array('Gestion Permisos', $_SESSION['permisos'])): ?>
                            <li><a href="GestionPermisos.php"><i class="fas fa-stethoscope"></i> Gestion Permisos</a></li>
                        <?php endif; ?>
                        <?php if (in_array('Tipos de consultas', $_SESSION['permisos'])): ?>
                            <li><a href="TipoConsultas.php"><i class="fas fa-stethoscope"></i> Tipo de Consultas</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </nav>
</div>




