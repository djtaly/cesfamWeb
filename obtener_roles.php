<?php
include('includes/db_connect.php');

$query = "SELECT id, nombre FROM roles";
$result = $conn->query($query);

$roles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

echo json_encode($roles);
?>

