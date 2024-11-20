<?php
include('includes/db_connect.php');

$examen_id = $_POST['examen_id'];
$prioridad_id = $_POST['prioridad_id'];
$tipo_consulta_id = $_POST['tipo_consulta_id'];
$observacion = $_POST['observacion'];
$usuario_categorizacion = $_POST['usuario_categorizacion'];

$query = "
    UPDATE examenes 
    SET 
        prioridad_id = '$prioridad_id',
        tipo_consulta_id = '$tipo_consulta_id',
        observacion = '$observacion',
        usuario_categorizacion = '$usuario_categorizacion'
    WHERE id = '$examen_id'
";

if ($conn->query($query) === TRUE) {
    echo "Categorización guardada con éxito.";
} else {
    echo "Error: " . $conn->error;
}
?>
