<?php
require_once "models/conexion.php";

class CategoriaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT 
            C.id_categoria AS 'id_categoria',
            C.nom_cat AS 'nom_cat',
            COUNT(P.id_producto) AS 'total_productos',
            C.fecha_registro AS 'fecha_registro',
            C.estado AS 'estado'
        FROM Categoria C
        LEFT JOIN Producto P ON C.id_categoria = P.id_categoria
        GROUP BY C.id_categoria, C.nom_cat, C.fecha_registro;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActive()
    {
        $sql = "SELECT * FROM Categoria WHERE estado = 1;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Categoria WHERE id_categoria = ?;");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Categoria (nom_cat) VALUES (?);");
        $stmt->execute([
            $data['nom_cat'],
        ]);
    }

    public function update($data)
    {
        $stmt = $this->db->prepare("UPDATE Categoria SET nom_cat = ? WHERE id_categoria = ?;");
        $stmt->execute([
            $data['nom_cat'],
            $data['id_categoria']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE Categoria SET estado = 0 where id_categoria = ?;");
        $stmt->execute([$id]);
    }
}
