<?php
require_once "models/conexion.php";

class PersonaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM Persona ORDER BY estado DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Persona WHERE id_persona = ?;");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function search($keyword)
    {
        $keyword = "%$keyword%";
        $stmt = $this->db->prepare("SELECT * FROM Persona 
                                WHERE (nombres LIKE ? OR apellidos LIKE ? OR dni LIKE ?) 
                                AND estado = 1 
                                ORDER BY estado DESC;");
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Persona (nombres, apellidos, dni, correo, telefono, direccion, nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?);");
        $stmt->execute([
            $data['nombres'],
            $data['apellidos'],
            $data['dni'],
            $data['correo'],
            $data['telefono'],
            $data['direccion'],
            $data['nacimiento'],
        ]);
    }

    public function update($data)
    {
        $stmt = $this->db->prepare("UPDATE Persona SET nombres = ?, apellidos = ?, dni = ?, correo = ?, telefono = ?, direccion = ?, nacimiento = ? WHERE id_persona = ?;");
        $stmt->execute([
            $data['nombres'],
            $data['apellidos'],
            $data['dni'],
            $data['correo'],
            $data['telefono'],
            $data['direccion'],
            $data['nacimiento'],
            $data['id_persona'],
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE Persona SET estado = 0 where id_persona = ?;");
        $stmt->execute([$id]);
    }
}