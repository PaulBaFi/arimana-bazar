<?php
session_start();
session_destroy(); // Borra toda la sesión
header("Location: login.php"); // Redirige al login
exit;
