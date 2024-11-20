<?php
session_start();
include('includes/db_connect.php');
include('includes/permisos.php');

// Verificar si el usuario tiene permiso para subir exámenes
if (!tienePermiso('Subir exámenes')) {
    echo '<p style="color: red;">No tienes permiso para acceder a esta sección.</p>';
    exit();
}

// Inicializar la variable $nombre_usuario
$nombre_usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Exámenes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* Ajustar el diseño de la página */
        .container {
            display: flex;
            height: 100vh; /* Altura completa de la ventana */
        }

        .sidebar {
            width: 250px; /* Ancho fijo de la barra lateral */
            background-color: #2c3e50; /* Fondo oscuro */
            color: white;
            padding: 20px;
        }

        .content {
            flex: 1; /* Toma el resto del espacio disponible */
            padding: 20px;
            overflow-y: auto; /* Habilitar desplazamiento si el contenido es largo */
        }

        #subirExamen {
            text-align: center;
            margin-top: 50px;
        }

        .modal-content {
            width: 100%;
            max-width: 500px; /* Limitar el ancho del modal */
            margin: auto;
        }

        .btn-agregar {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-agregar:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Barra lateral -->
        <aside class="sidebar">
            <?php include('navegacion.php'); ?>
        </aside>

        <!-- Contenido principal -->
        <main class="content">
            <div id="subirExamen" class="seccion">
                <h3>Buscar Paciente por RUN</h3>
                <div style="display: flex; justify-content: center; margin-top: 20px;">
                    <input type="text" id="buscar-examen-run" placeholder="Ingrese RUN del paciente" style="width: 300px; padding: 10px;">
                    <button onclick="buscarPaciente()" class="btn-agregar" style="margin-left: 10px;">Buscar</button>
                </div>
            </div>

            <!-- Modal: Subir Examen -->
            <div id="modalSubirExamen" class="modal" style="display: none;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Subir Examen</h3>
                        <span class="close" onclick="cerrarModal('modalSubirExamen')">&times;</span>
                    </div>
                    <form id="formSubirExamen" enctype="multipart/form-data">
                        <input type="hidden" id="examen-id" name="paciente_id">
                        <p><strong>RUN:</strong> <span id="examen-run"></span></p>
                        <p><strong>Nombre:</strong> <span id="examen-nombre"></span></p>
                        <p><strong>Apellidos:</strong> <span id="examen-apellidos"></span></p>
                        <p><strong>Fecha de Nacimiento:</strong> <span id="examen-fecha-nacimiento"></span></p>
                        <p><strong>Edad:</strong> <span id="examen-edad"></span></p>
                        <input type="file" name="archivo" accept=".pdf" required>
                        <button type="submit" class="btn-guardar">Subir Examen</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="js/subirExamen.js"></script>
</body>
</html>



