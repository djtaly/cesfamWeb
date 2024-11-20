<?php
session_start();
include('includes/db_connect.php');

// Verificar si el paciente ha iniciado sesión
if (!isset($_SESSION['paciente_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del paciente de la sesión
$paciente_id = $_SESSION['paciente_id'];
$paciente_run = $_SESSION['paciente_run'];
$paciente_nombre = $_SESSION['paciente_nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Exámenes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* Tabla de Exámenes */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #2c3e50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        /* Botón Ver Examen */
        .btn-ver {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }

        .btn-ver:hover {
            background-color: #2980b9;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 80%;
            max-height: 80%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: auto;
            text-align: center;
        }

        .modal img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 5px;
        }

        .modal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #aaa;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal .close:hover {
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2>Panel de Paciente</h2>
            <p><strong>Paciente:</strong> <?php echo htmlspecialchars("$paciente_run"); ?></p>
            <nav>
                <ul>
                    <li><a href="PacienteExamenes.php"><i class="fas fa-file-medical"></i> Mis Exámenes</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                </ul>
            </nav>
        </aside>

        <div class="content">
            <h3>Mis Exámenes</h3>
            <table id="tablaExamenes">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Examen</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consultar exámenes relacionados con el paciente
                    $query = "SELECT e.id, e.created_at, e.archivo
                              FROM examenes e
                              WHERE e.paciente_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $paciente_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($examen = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$examen['id']}</td>
                                    <td>{$examen['created_at']}</td>
                                    <td><button class='btn-ver' onclick=\"verExamen('uploads/{$examen['archivo']}')\">Ver Examen</button></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No se encontraron exámenes.</td></tr>";
                    }

                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>

    <!-- Modal para visor de examen -->
<div id="modalExamen" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <!-- Visor de imágenes -->
        <img id="imagenExamen" src="" alt="Examen" style="max-width: 100%; max-height: 100%; display: none;">
        <!-- Visor de PDF -->
        <iframe id="visorPDF" src="" style="width: 100%; height: 500px; display: none;" frameborder="0"></iframe>
    </div>
</div>

    </div>

    <script>
        // Función para abrir el modal y mostrar el examen
        function verExamen(ruta) {
            const modal = document.getElementById('modalExamen');
            const imagen = document.getElementById('imagenExamen');
            imagen.src = ruta;
            modal.style.display = 'flex';
        }

        // Función para cerrar el modal
        function cerrarModal() {
            const modal = document.getElementById('modalExamen');
            modal.style.display = 'none';
            document.getElementById('imagenExamen').src = ""; // Limpiar la imagen para evitar que quede cargada
        }

        // Cerrar modal al hacer clic fuera del contenido
        window.onclick = function(event) {
            const modal = document.getElementById('modalExamen');
            if (event.target === modal) {
                cerrarModal();
            }
        };
		

    function verExamen(ruta) {
        const modal = document.getElementById('modalExamen');
        const visorImagen = document.getElementById('imagenExamen');
        const visorPDF = document.getElementById('visorPDF');

        const extension = ruta.split('.').pop().toLowerCase();

        // Si es una imagen
        if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
            visorImagen.src = ruta;
            visorImagen.style.display = 'block';
            visorPDF.style.display = 'none';
        }
        // Si es un PDF
        else if (extension === 'pdf') {
            visorPDF.src = ruta;
            visorPDF.style.display = 'block';
            visorImagen.style.display = 'none';
        }
        // Si el formato no es soportado
        else {
            alert('Formato de archivo no soportado');
            return;
        }

        modal.style.display = 'flex';
    }

    function cerrarModal() {
        const modal = document.getElementById('modalExamen');
        document.getElementById('imagenExamen').src = "";
        document.getElementById('visorPDF').src = "";
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalExamen');
        if (event.target === modal) {
            cerrarModal();
        }
    };


    </script>
</body>
</html>

