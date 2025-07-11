<?php
// Verifica si el usuario está autenticado
// Si no está autenticado, redirige a la página de inicio de sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
