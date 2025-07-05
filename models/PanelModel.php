<?php

require_once "models/conexion.php";

class PanelModel
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
    public function getTotalClientes()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM Cliente");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalProductos()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM Producto WHERE estado = '1'");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalVentas()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM Venta");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalPedidos()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM Pedido");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getVentasPorMes()
    {
        $stmt = $this->db->prepare("SELECT DATE_FORMAT(fecha_venta, '%Y-%m') AS mes, SUM(total_pagar) AS total
        FROM Venta
        GROUP BY mes
        ORDER BY mes DESC
        LIMIT 6
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductosMasVendidos()
    {
        $stmt = $this->db->prepare("SELECT P.nom_prod, SUM(DV.cantidad) AS total_vendidos
        FROM DetalleVenta DV
        INNER JOIN Producto P ON DV.id_producto = P.id_producto
        GROUP BY DV.id_producto
        ORDER BY total_vendidos DESC
        LIMIT 5
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStockPorCategoria()
    {
        $stmt = $this->db->prepare("SELECT C.nom_cat AS categoria, SUM(P.existencia) AS stock_total
        FROM Producto P
        INNER JOIN Categoria C ON P.id_categoria = C.id_categoria
        GROUP BY C.nom_cat
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
