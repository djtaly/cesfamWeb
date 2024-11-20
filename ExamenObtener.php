<?php
session_start();
include('includes/db_connect.php');

// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si el usuario tiene permiso para revisar exámenes
if (!isset($_SESSION['permisos']) || !in_array('Revisar exámenes', $_SESSION['permisos'])) {
    http_response_code(403);
    echo json_encode(['error' => 'No tienes permiso para realizar esta acción.']);
    exit();
}

header('Content-Type: application/json');

try {
    // Consulta para obtener exámenes con la información del paciente, prioridades y tipo de consulta
    $query = "
        SELECT 
            e.id AS examen_id,
            p.run,
            CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS nombre_completo,
            e.archivo,
            e.observacion,
            pr.nombre AS prioridad,
            tc.nombre AS tipo_consulta,
            e.usuario_categorizacion,
            e.created_at AS fecha_examen
        FROM 
            examenes e
        INNER JOIN 
            pacientes p ON e.paciente_id = p.id
        LEFT JOIN 
            prioridades pr ON e.prioridad_id = pr.id
        LEFT JOIN 
            tipos_consulta tc ON e.tipo_consulta_id = tc.id
        ORDER BY 
            e.created_at DESC
    ";

    $result = $conn->query($query);

    if ($result === false) {
        throw new Exception("Error en la consulta SQL: " . $conn->error);
    }

    $examenes = [];
    while ($row = $result->fetch_assoc()) {
        $examenes[] = [
            'id' => $row['examen_id'],
            'run' => $row['run'],
            'nombre' => $row['nombre_completo'],
            'fecha_examen' => $row['fecha_examen'],
            'prioridad' => $row['prioridad'] ?? 'Sin Categorizar',
            'tipo_consulta' => $row['tipo_consulta'] ?? 'Sin Categorizar',
            'observacion' => $row['observacion'] ?? 'Sin Observación',
            'archivo' => $row['archivo'],
            'usuario_categorizacion' => $row['usuario_categorizacion'] ?? 'No Asignado'
        ];
    }

    echo json_encode($examenes);

} catch (Exception $e) {
    // Manejo de errores
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>

