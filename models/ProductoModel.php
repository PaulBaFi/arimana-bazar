<?php
require_once "models/conexion.php";

class ProductoModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT P.id_producto AS 'id_producto',
            C.id_categoria AS 'id_categoria',
            C.nom_cat AS 'nom_cat', 
            P.nom_prod AS 'nom_prod', 
            P.descripcion_prod AS 'descripcion_prod', 
            P.existencia AS 'existencia', 
            P.precio AS 'precio', 
            P.fecha_registro AS 'fecha_registro', 
            P.estado AS 'estado'
        FROM Producto P 
        INNER JOIN CATEGORIA C ON C.id_categoria = P.id_categoria;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActive()
    {
        $sql = "SELECT * FROM Producto WHERE estado = 1;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT 
            P.*, C.nom_cat, C.id_categoria 
        FROM Producto P 
        INNER JOIN Categoria C ON P.id_categoria = C.id_categoria 
        WHERE P.id_producto = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Producto (id_categoria, nom_prod, descripcion_prod, precio, existencia) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['id_categoria'],
            $data['nom_prod'],
            $data['descripcion_prod'],
            $data['precio'],
            $data['existencia']
        ]);
    }

    public function update($data)
    {
        $stmt = $this->db->prepare("UPDATE Producto SET id_categoria = ?, nom_prod = ?, descripcion_prod = ?, precio = ?, existencia = ? WHERE id_producto = ?");
        $stmt->execute([
            $data['id_categoria'],
            $data['nom_prod'],
            $data['descripcion_prod'],
            $data['precio'],
            $data['existencia'],
            $data['id_producto']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE Producto SET estado = 0 where id_producto = ?;");
        $stmt->execute([$id]);
    }
}
