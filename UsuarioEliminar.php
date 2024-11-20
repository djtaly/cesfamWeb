<?php
include('includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if (!$id) {
        echo 'ID de usuario no proporcionado.';
        exit();
    }

    try {
        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo 'Usuario eliminado exitosamente.';
        } else {
            throw new Exception('Error al eliminar el usuario.');
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
    }
}
?>

