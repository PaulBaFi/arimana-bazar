<?php

require_once "models/conexion.php";

class PrincipalModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getUserName()
    {
        if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nombres'])) {
            return htmlspecialchars($_SESSION['usuario']['nombres']);
        }
        // Si no hay usuario en sesión, retornar un string vacío
        return '';
    }

    // Obtener mas estadísticas de la BD en funciones...
}
