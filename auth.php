<?php
session_start();
require_once "models/conexion.php";

$correo = trim($_POST['correo']);
$clave = trim($_POST['clave']);

try {
    $pdo = Conexion::conectar();
    $stmt = $pdo->prepare("SELECT u.*, p.nombres, p.apellidos 
        FROM Usuario u 
        INNER JOIN Persona p ON u.id_persona = p.id_persona 
        WHERE u.correo = ? AND u.clave = ?
        ");
    $stmt->execute([$correo, $clave]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['usuario'] = [
            'id' => $usuario['id_usuario'],
            'nombres' => $usuario['nombres'] . ' ' . $usuario['apellidos'],
            'correo' => $usuario['correo'],
            'rol' => $usuario['rol']
        ];
        header("Location: index.php?controller=panel&action=index");
    } else {
        header("Location: login.php?error=no_encontrado");
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
