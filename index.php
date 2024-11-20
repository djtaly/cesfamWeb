<?php
session_start();

// Si el usuario ya ha iniciado sesión, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: menu.php");
    exit();
} else {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: login.php");
    exit();
}
?>






