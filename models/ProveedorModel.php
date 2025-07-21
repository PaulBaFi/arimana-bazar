<?php
require_once "models/conexion.php";

class ProveedorModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT E.*, P.* FROM Proveedor P 
        INNER JOIN Empresa E ON P.id_empresa = E.id_empresa
        ORDER BY estado DESC
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Proveedor WHERE id_proveedor = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Proveedor (id_empresa) VALUES (?);");

        $stmt->execute([
            $data['id_empresa']
        ]);
    }

    public function update($data)
    {
        $stmt = $this->db->prepare("UPDATE Empresa SET razonsocial = ?, ruc = ?, correo = ?, telefono = ?,  direccion = ? WHERE id_empresa = ?;");
        $stmt->execute([
            $data['razonsocial'],
            $data['ruc'],
            $data['correo'],
            $data['telefono'],
            $data['direccion'],
            $data['id_empresa'],
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM Proveedor WHERE id_proveedor = ?");
        $stmt->execute([$id]);
    }
}
