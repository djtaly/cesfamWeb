<?php
session_start();
include('includes/db_connect.php');

// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario tiene permisos para categorizar exámenes
if (!isset($_SESSION['permisos']) || !in_array('Categorizar exámenes', $_SESSION['permisos'])) {
    http_response_code(403);
    echo 'No tienes permiso para realizar esta acción.';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $examen_id = $_POST['examen_id'];
    $prioridad_id = $_POST['prioridad_id'];
    $tipo_consulta_id = $_POST['tipo_consulta_id'];
    $observacion = $_POST['observacion'];
    $usuario_categorizacion = $_SESSION['nombre'];

    // Validar que todos los campos requeridos estén presentes
    if (!$examen_id || !$prioridad_id || !$tipo_consulta_id) {
        echo 'Faltan datos obligatorios.';
        exit();
    }

    try {
        // Actualizar el examen en la base de datos
        $query = "UPDATE examenes 
                  SET prioridad_id = ?, tipo_consulta_id = ?, observacion = ?, usuario_categorizacion = ? 
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iissi", $prioridad_id, $tipo_consulta_id, $observacion, $usuario_categorizacion, $examen_id);

        if ($stmt->execute()) {
            echo 'Categorización actualizada exitosamente.';
        } else {
            throw new Exception("Error al actualizar la categorización: " . $conn->error);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
    }
} else {
    http_response_code(405);
    echo 'Método no permitido.';
}
?>

