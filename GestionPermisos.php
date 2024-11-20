<?php
session_start();
include('includes/db_connect.php');
include('includes/permisos.php');

// Verificar si el usuario tiene permiso para Gestionar Permisos
if (!tienePermiso('Gestion Permisos')) {
    echo '<p style="color: red;">No tienes permiso para acceder a esta sección.</p>';
    exit();
}

// Inicializar la variable $nombre_usuario y $apellido_usuario
$nombre_usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Permisos</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .container {
            margin-left: 260px;
            padding: 20px;
        }
			/* Tabla de Permisos */
			#tablaPermisos {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
			}

			#tablaPermisos th, #tablaPermisos td {
				padding: 12px 15px;
				border: 1px solid #ddd;
				text-align: left;
			}

			#tablaPermisos th {
				background-color: #2c3e50; /* Color de fondo de la cabecera */
				color: white; /* Color del texto de la cabecera */
			}

			#tablaPermisos tr:nth-child(even) {
				background-color: #f2f2f2; /* Color de fondo para las filas pares */
			}

			#tablaPermisos tr:hover {
				background-color: #ddd; /* Color de fondo al pasar el ratón por encima */
			}


        .modal-content {
            width: 100%;
            max-width: 600px;
            margin: auto;
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
        <!-- Navegación lateral -->
        <aside class="sidebar">
            <?php include('navegacion.php'); ?>
        </aside>

        <main class="content">
            <div id="gestionPermisos" class="seccion">
                <h3>Gestión de Permisos</h3>
                <!-- Botón para abrir modal -->
                <button onclick="abrirModal('modalGestionPermisos')" class="btn-agregar">Asignar Nuevo Permiso</button>
                <table id="tablaPermisos">
                    <thead>
                        <tr>
                            <th>Rol</th>
                            <th>Permiso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los permisos asignados se cargarán dinámicamente aquí -->
                    </tbody>
                </table>
            </div>

            <!-- Modal: Gestión de Permisos -->
            <div id="modalGestionPermisos" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModal('modalGestionPermisos')">&times;</span>
                    <h3>Asignar Permiso</h3>
                    <form id="formGestionPermisos">
                        <label for="rol_id">Rol:</label>
                        <select id="rol_id" name="rol_id" required>
                            <option value="">Seleccione un Rol</option>
                            <?php
                            $roles = $conn->query("SELECT id, nombre FROM roles");
                            while ($rol = $roles->fetch_assoc()) {
                                echo "<option value='{$rol['id']}'>{$rol['nombre']}</option>";
                            }
                            ?>
                        </select>
                        <label for="permiso_id">Permiso:</label>
                        <select id="permiso_id" name="permiso_id" required>
                            <option value="">Seleccione un Permiso</option>
                            <?php
                            $permisos = $conn->query("SELECT id, nombre FROM permisos");
                            while ($permiso = $permisos->fetch_assoc()) {
                                echo "<option value='{$permiso['id']}'>{$permiso['nombre']}</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="btn-guardar">Guardar</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        cargarPermisos();

        // Configurar el formulario para asignar permisos
        const formGestionPermisos = document.getElementById('formGestionPermisos');
        if (formGestionPermisos) {
            formGestionPermisos.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch('PermisosAsignar.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert(data.message); // Mostrar mensaje de éxito
                            cerrarModal('modalGestionPermisos');
                            cargarPermisos(); // Recargar la tabla
                        } else {
                            alert(data.message); // Mostrar mensaje de error
                        }
                    })
                    .catch(error => console.error('Error al asignar permiso:', error));
            });
        }
    });

    function cargarPermisos() {
        fetch('PermisosObtener.php') // Llamada al endpoint
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    const permisos = data.data;

                    // Destruir el DataTable existente (si está inicializado)
                    if ($.fn.DataTable.isDataTable('#tablaPermisos')) {
                        $('#tablaPermisos').DataTable().destroy();
                    }

                    // Insertar datos en la tabla
                    const tbody = document.querySelector('#tablaPermisos tbody');
                    tbody.innerHTML = '';
                    permisos.forEach(asignacion => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${asignacion.rol}</td>
                                <td>${asignacion.permiso}</td>
                                <td>
                                    <button onclick="eliminarPermiso(${asignacion.rol_id}, ${asignacion.permiso_id})" class="btn-eliminar">Eliminar</button>
                                </td>
                            </tr>`;
                    });

                    // Inicializar DataTable después de cargar los datos
                    $('#tablaPermisos').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                        },
                        destroy: true // Permite reinicializar
                    });
                } else {
                    console.error('Error en los datos devueltos:', data.message);
                }
            })
            .catch(error => console.error('Error al cargar permisos:', error));
    }

    function eliminarPermiso(rol_id, permiso_id) {
        if (confirm('¿Está seguro de que desea eliminar este permiso?')) {
            fetch('PermisosEliminar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ rol_id, permiso_id })
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    cargarPermisos(); // Recargar la tabla
                })
                .catch(error => console.error('Error al eliminar permiso:', error));
        }
    }

    function abrirModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'flex';
        } else {
            console.error(`No se encontró el modal con el ID: ${id}`);
        }
    }

    function cerrarModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'none';
        } else {
            console.error(`No se encontró el modal con el ID: ${id}`);
        }
    }
</script>

</body>
</html>


