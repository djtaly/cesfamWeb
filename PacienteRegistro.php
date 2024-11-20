<?php
include('includes/auth.php');

verificarPermiso('Registrar pacientes');
echo "Permiso verificado correctamente.";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pacientes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
	<style>/* Estilo de los mensajes */
.mensaje {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    z-index: 1001;
    color: #fff;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: fadeIn 0.5s, fadeOut 0.5s 2.5s; /* Animación de entrada y salida */
}

.mensaje.success {
    background-color: #2ecc71; /* Verde para éxito */
}

.mensaje.error {
    background-color: #e74c3c; /* Rojo para errores */
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-10px);
    }
}
	
		/* Contenedor del formulario */
.modal-content form {
    display: flex;
    flex-direction: column;
    gap: 15px; /* Espacio entre filas */
}

/* Cada fila del formulario */
.form-row {
    display: flex;
    gap: 10px; /* Espacio entre inputs dentro de una fila */
}

/* Estilo para los inputs */
form input {
    flex: 1; /* Los inputs ocuparán el mismo espacio */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

/* Estilo para el botón */
.btn-guardar {
    background-color: #2ecc71;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn-guardar:hover {
    background-color: #27ae60;
}

/* Mejorar el diseño del modal */
.modal-content {
    background-color: white;
    padding: 20px;
    width: 100%;
    max-width: 500px;
    border-radius: 10px;
    position: relative;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}
		
		@media (max-width: 600px) {
    .form-row {
        flex-direction: column;
        gap: 10px; /* Espacio entre inputs en columnas */
    }

    form input {
        width: 100%; /* Ocupan el 100% del ancho del contenedor */
    }

    .btn-guardar {
        width: 100%;
    }
}



</style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <?php include('navegacion.php'); ?>
        </aside>
        <main class="content">
            <div id="registroPaciente" class="seccion">
                <h3>Pacientes Registrados</h3>
                <button onclick="abrirModalPaciente('modalNuevoPaciente')" class="btn-agregar">Agregar Nuevo Paciente</button>
                <table id="tablaPacientes" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>RUN</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Edad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se cargarán los pacientes dinámicamente -->
                    </tbody>
                </table>
            </div>

					<div id="modalNuevoPaciente" class="modal" style="display: none;">
						<div class="modal-content">
							<span class="close" onclick="cerrarModalPaciente('modalNuevoPaciente')">&times;</span>
							<h3>Registrar Paciente</h3>
							<form id="formNuevoPaciente">
								<!-- Contenedor flexible para organizar inputs -->
								<div class="form-row">
									<input type="text" name="run" placeholder="RUN (sin puntos ni guiones)" required>
									<input type="text" name="nombre" placeholder="Nombre" required>
								</div>
								<div class="form-row">
									<input type="text" name="apellido_paterno" placeholder="Apellido Paterno" required>
									<input type="text" name="apellido_materno" placeholder="Apellido Materno" required>
								</div>
								<div class="form-row">
									<input type="date" name="fecha_nacimiento" required>
									<input type="password" name="password" placeholder="Contraseña" required>
								</div>
								<button type="submit" class="btn-guardar">Registrar Paciente</button>
							</form>
						</div>
					</div>




					<div id="modalEditarPaciente" class="modal" style="display: none;">
						<div class="modal-content">
							<span class="close" onclick="cerrarModalPaciente('modalEditarPaciente')">&times;</span>
							<h3>Editar Paciente</h3>
							<form id="formEditarPaciente">
								<input type="hidden" id="editar-id" name="id">
								<input type="text" id="editar-run" name="run" placeholder="RUN" required>
								<input type="text" id="editar-nombre" name="nombre" placeholder="Nombre" required>
								<input type="text" id="editar-apellido-paterno" name="apellido_paterno" placeholder="Apellido Paterno" required>
								<input type="text" id="editar-apellido-materno" name="apellido_materno" placeholder="Apellido Materno" required>
								<input type="date" id="editar-fecha-nacimiento" name="fecha_nacimiento" required>
								<button type="submit" class="btn-guardar">Guardar Cambios</button>
							</form>
						</div>
					</div>


    <script src="js/pacienteRegistro.js"></script>
</body>
</html>





