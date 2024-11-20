<?php
include('includes/db_connect.php');

header('Content-Type: application/json');

try {
    $result = $conn->query("SELECT id, nombre FROM roles");

    $roles = [];
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }

    echo json_encode($roles);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>

