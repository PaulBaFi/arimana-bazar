<?php

require_once "models/conexion.php";

class LandingModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    // Verificar si el usuario está logueado
    public function isUserLoggedIn()
    {
        return isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);
    }


    // Obtener mas estadísticas de la BD en funciones...
}
