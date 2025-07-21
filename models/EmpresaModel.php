<?php
require_once "models/conexion.php";

class EmpresaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM Empresa ORDER BY estado DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActive()
    {
        $sql = "SELECT * FROM Empresa WHERE estado = 1";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Empresa WHERE id_empresa = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Empresa (razonsocial, ruc, correo, telefono, direccion) VALUES (?, ?, ?, ?, ?);");
        $stmt->execute([
            $data['razonsocial'],
            $data['ruc'],
            $data['correo'],
            $data['telefono'],
            $data['direccion'],
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
        $stmt = $this->db->prepare("UPDATE Empresa SET estado = 0 where id_empresa = ?;");
        $stmt->execute([$id]);
    }
}
