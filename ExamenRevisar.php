<?php
session_start();
include('includes/db_connect.php');
include('includes/permisos.php');

// Verificar si el usuario tiene permiso para revisar exámenes
if (!tienePermiso('Revisar exámenes')) {
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
    <title>Revisar Exámenes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* Tabla de exámenes */
        #tablaExamenes {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #tablaExamenes th, #tablaExamenes td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #tablaExamenes th {

            font-weight: bold;
        }

        /* Modal */
        .modal-content {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }

        .modal-content label, .modal-content select, .modal-content textarea {
            display: block;
            margin-bottom: 10px;
            width: 100%;
        }

        .btn-guardar {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-guardar:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <?php include('navegacion.php'); ?>
        </aside>

        <main class="content">
            <div id="revisarExamen" class="seccion">
                <h3>Revisar Exámenes</h3>
                <table id="tablaExamenes">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>RUN</th>
                            <th>Nombre</th>
                            <th>Fecha de Examen</th>
                            <th>Prioridad</th>
                            <th>Tipo de Consulta</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                            <th>Usuario Categorización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los exámenes se cargarán dinámicamente aquí -->
                    </tbody>
                </table>
            </div>

            <!-- Modal: Ver Examen -->
            <div id="modalVerExamen" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModal('modalVerExamen')">&times;</span>
                    <iframe id="visorExamen" width="100%" height="500px" frameborder="0"></iframe>
                </div>
            </div>

            <!-- Modal: Categorización -->
            <div id="modalCategorizacion" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModal('modalCategorizacion')">&times;</span>
                    <h3>Categorizar Examen</h3>
											   <form id="formCategorizacion">
								<input type="hidden" id="categorizacion-id" name="examen_id">
								<label for="prioridad">Prioridad:</label>
								<select id="prioridad" name="prioridad_id" required>
									<option value="">Seleccione...</option>
									<option value="1">Alta</option>
									<option value="2">Media</option>
									<option value="3">Baja</option>
								</select>
								<label for="tipo_consulta">Tipo de Consulta:</label>
								<select id="tipo_consulta" name="tipo_consulta_id" required>
									<option value="">Seleccione...</option>
									<option value="1">Control General</option>
									<option value="2">Urgencias</option>
									<option value="3">Especialidad</option>
								</select>
								<label for="observacion">Observación:</label>
								<textarea id="observacion" name="observacion" rows="3" placeholder="Añadir observaciones..."></textarea>
								<button type="submit" class="btn-guardar">Guardar</button>
							</form>

                </div>
            </div>
        </main>
    </div>

    <script>
        // Cargar exámenes en la tabla
        document.addEventListener('DOMContentLoaded', () => {
            cargarExamenes();
        });

        function cargarExamenes() {
            fetch('ExamenObtener.php') // Endpoint que devuelve los datos de los exámenes
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#tablaExamenes tbody');
                    tbody.innerHTML = '';
                    data.forEach(examen => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${examen.id}</td>
                                <td>${examen.run}</td>
                                <td>${examen.nombre}</td>
                                <td>${examen.fecha_examen}</td>
                                <td>${examen.prioridad || 'Sin Categorizar'}</td>
                                <td>${examen.tipo_consulta || 'Sin Categorizar'}</td>
                                <td>${examen.observacion || 'Sin Observación'}</td>
                                <td>
                                    <button onclick="verExamen('${examen.archivo}')">Ver</button>
                                    <button onclick="abrirModalCategorizacion(${examen.id})">Categorizar</button>
                                </td>
                                <td>${examen.usuario_categorizacion || 'No Asignado'}</td>
                            </tr>`;
                    });
                })
                .catch(error => console.error('Error al cargar exámenes:', error));
        }

        // Función para ver un examen
        function verExamen(archivo) {
            const visor = document.getElementById('visorExamen');
            visor.src = `uploads/${archivo}`;
            abrirModal('modalVerExamen');
        }

        // Función para abrir modal de categorización
        function abrirModalCategorizacion(id) {
            document.getElementById('categorizacion-id').value = id;
            abrirModal('modalCategorizacion');
        }

        // Guardar categorización
        document.getElementById('formCategorizacion').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('usuario', '<?php echo $nombre_usuario . ' ' . $apellido_usuario; ?>'); // Añadir el usuario que realiza la categorización

            fetch('ExamenCategorizar.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    cerrarModal('modalCategorizacion');
                    cargarExamenes(); // Recargar la tabla
                })
                .catch(error => console.error('Error al guardar categorización:', error));
        });

        // Función para abrir un modal
        function abrirModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        // Función para cerrar un modal
        function cerrarModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
</body>
</html>



