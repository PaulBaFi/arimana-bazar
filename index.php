<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // Si no ha iniciado sesión, mostrar la landing page
    include_once "./landing/index.php";
    exit;
}

// Usuario logueado: proteger acceso
require_once "middleware/auth_guard.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once "./views/layout/head.php"; ?>
</head>

<body>
    <?php include_once "./views/layout/navbar.php"; ?>

    <div class="main-container">
        <?php
        define('BASE_PATH', __DIR__);
        include_once "route.php";
        ?>
    </div>

    <?php include_once "./views/layout/footer.php"; ?>
</body>

</html>