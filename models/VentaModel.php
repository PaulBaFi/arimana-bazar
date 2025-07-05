<?php

require_once "models/conexion.php";

class VentaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM Venta;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
