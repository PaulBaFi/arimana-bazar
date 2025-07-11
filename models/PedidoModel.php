<?php
require_once __DIR__ . '/conexion.php';

class PedidoModel
{
    private $model;

    public function __construct()
    {
        $this->model = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT 
            p.id_pedido,
            CONCAT(per.nombres, ' ', per.apellidos) AS usuario,
            u.rol AS rol,
            emp.razonsocial AS proveedor,
            p.total_pagar,
            p.observacion,
            p.fecha_pedido,
            COALESCE(SUM(dp.cantidad), 0) AS total_productos
        FROM Pedido p
        INNER JOIN Usuario u ON p.id_usuario = u.id_usuario
        INNER JOIN Persona per ON u.id_persona = per.id_persona
        INNER JOIN Proveedor pr ON p.id_proveedor = pr.id_proveedor
        INNER JOIN Empresa emp ON pr.id_empresa = emp.id_empresa
        LEFT JOIN DetallePedido dp ON p.id_pedido = dp.id_pedido
        GROUP BY 
            p.id_pedido, per.nombres, per.apellidos, u.rol, emp.razonsocial,
            p.total_pagar, p.observacion, p.fecha_pedido
        ORDER BY p.fecha_pedido DESC;";
        return $this->model->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUsuarios()
    {
        $sql = "SELECT u.id_usuario, CONCAT(p.nombres, ' ', p.apellidos) AS nombre
                FROM Usuario u
                JOIN Persona p ON u.id_persona = p.id_persona
                WHERE u.estado = '1'";
        return $this->model->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProveedores()
    {
        $sql = "SELECT pr.id_proveedor, e.razonsocial
                FROM Proveedor pr
                JOIN Empresa e ON pr.id_empresa = e.id_empresa
                WHERE e.estado = '1'";
        return $this->model->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductos()
    {
        $sql = "SELECT id_producto, nom_prod, precio FROM Producto WHERE estado = '1'";
        return $this->model->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($id)
    {
        $stmt = $this->model->prepare("SELECT id_producto, precio FROM Producto WHERE id_producto = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerDetallePedido($id_pedido)
    {
        $sql = "SELECT 
                PR.nom_prod AS producto,
                DP.cantidad,
                PR.precio,
                DP.subtotal
            FROM DetallePedido DP
            JOIN Producto PR ON DP.id_producto = PR.id_producto
            WHERE DP.id_pedido = ?";

        $stmt = $this->model->prepare($sql);
        $stmt->execute([$id_pedido]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPedidoPorId($id_pedido)
    {
        $sql = "SELECT 
            P.id_pedido,
            P.observacion,
            P.fecha_pedido,
            CONCAT(PE.nombres, ' ', PE.apellidos) AS usuario,
            U.rol,
            EM.razonsocial AS proveedor,
            EM.ruc,
            EM.direccion
        FROM Pedido P
        JOIN Usuario U ON P.id_usuario = U.id_usuario
        JOIN Persona PE ON U.id_persona = PE.id_persona
        JOIN Proveedor PR ON P.id_proveedor = PR.id_proveedor
        JOIN Empresa EM ON PR.id_empresa = EM.id_empresa
        WHERE P.id_pedido = ?";

        $stmt = $this->model->prepare($sql);
        $stmt->execute([$id_pedido]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarTotalPedido($id_pedido, $total)
    {
        $stmt = $this->model->prepare("UPDATE Pedido SET total_pagar = ? WHERE id_pedido = ?");
        $stmt->execute([$total, $id_pedido]);
    }

    public function insertarPedido($data)
    {
        $sql = "INSERT INTO Pedido (id_usuario, id_proveedor, total_pagar, observacion, fecha_pedido)
                VALUES (:id_usuario, :id_proveedor, :total_pagar, :observacion, :fecha_pedido)";
        $stmt = $this->model->prepare($sql);
        $stmt->execute($data);
        return $this->model->lastInsertId();
    }

    public function insertarDetalle($detalle)
    {
        $sql = "INSERT INTO DetallePedido (id_pedido, id_producto, cantidad, subtotal)
                VALUES (:id_pedido, :id_producto, :cantidad, :subtotal)";
        $stmt = $this->model->prepare($sql);
        $stmt->execute($detalle);
    }

    public function create()
    {
        include "views/pedidos/form.php";
    }

    public function store($data) {}

    public function editar($id) {}

    public function update($data) {}
}
