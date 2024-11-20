<?php
include('includes/db_connect.php');

try {
    $query = "SELECT r.nombre AS rol, r.id AS rol_id, p.nombre AS permiso, p.id AS permiso_id
              FROM rol_permiso rp
              INNER JOIN roles r ON rp.rol_id = r.id
              INNER JOIN permisos p ON rp.permiso_id = p.id";
    $result = $conn->query($query);

    $permisos = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $permisos[] = $row;
        }
    }

    // Guardar datos en un archivo para depuración
    file_put_contents('debug.json', json_encode(['status' => 'success', 'data' => $permisos]));

    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'data' => $permisos]);
} catch (Exception $e) {
    header('Content-Type: application/json', true, 500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
