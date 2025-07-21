<?php
require_once "models/conexion.php";

class UsuarioModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT u.*, 
        p.nombres, p.apellidos, p.dni
        FROM Usuario u
        INNER JOIN Persona p ON u.id_persona = p.id_persona
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT u.*, 
        p.nombres, p.apellidos 
        FROM Usuario u
        INNER JOIN Persona p ON u.id_persona = p.id_persona
        WHERE u.id_usuario = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($correo)
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Usuario (id_persona, correo, clave, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['id_persona'],
            $data['correo'],
            $data['clave'],
            $data['rol']
        ]);
    }

    public function update($data)
    {
        $stmt = $this->db->prepare("UPDATE Usuario SET id_persona = ?, correo = ?, clave = ?, rol = ? WHERE id_usuario = ?");
        $stmt->execute([
            $data['id_persona'],
            $data['correo'],
            $data['clave'],
            $data['rol'],
            $data['id_usuario']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE Usuario SET estado = 0 WHERE id_usuario = ?");
        $stmt->execute([$id]);
    }
}
