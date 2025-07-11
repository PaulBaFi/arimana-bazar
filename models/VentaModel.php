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
        $sql = "SELECT V.ID_VENTA
            , CONCAT(PER.NOMBRES, ' ', PER.APELLIDOS) AS usuario
            , U.ROL as rol
            , COALESCE(CONCAT(P.NOMBRES, ' ', P.APELLIDOS), E.RAZONSOCIAL) AS cliente
            , V.OBSERVACION
            , CASE WHEN V.DOCUMENTO = 'F' THEN 'FACTURA' ELSE 'BOLETA' END AS documento
            , '18%' AS 'igv'
            , V.FECHA_VENTA AS 'fecha_venta'
        FROM VENTA V

        INNER JOIN USUARIO U ON U.ID_USUARIO = V.ID_USUARIO
        INNER JOIN PERSONA PER ON PER.ID_PERSONA = U.ID_PERSONA
        INNER JOIN CLIENTE C ON C.ID_CLIENTE = V.ID_CLIENTE
        LEFT JOIN PERSONA P ON P.ID_PERSONA = C.ID_PERSONA
        LEFT JOIN EMPRESA E ON E.ID_EMPRESA = C.ID_EMPRESA;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerUsuarios()
    {
        $sql = "SELECT u.id_usuario, CONCAT(p.nombres, ' ', p.apellidos) AS nombre
                FROM Usuario u
                JOIN Persona p ON u.id_persona = p.id_persona
                WHERE u.estado = '1';";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerClientes()
    {
        $sql = "SELECT 
            C.id_cliente,
            COALESCE(
                CONCAT(P.NOMBRES, ' ', P.APELLIDOS)
                , E.RAZONSOCIAL) AS cliente
        FROM Cliente C
        LEFT JOIN Persona P ON C.id_persona = P.id_persona
        LEFT JOIN Empresa E ON C.id_empresa = E.id_empresa;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductos()
    {
        $sql = "SELECT id_producto, nom_prod, precio FROM Producto WHERE estado = '1'";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($id)
    {
        $stmt = $this->db->prepare("SELECT id_producto, precio FROM Producto WHERE id_producto = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerDetalleVenta($id_venta)
    {
        $sql = "SELECT 
            DV.ID_DETALLE_VENTA AS COD,
            P.NOM_PROD AS PRODUCTO,
            DV.CANTIDAD,
            V.IGV,
            DV.SUBTOTAL,
            ROUND(DV.SUBTOTAL + (DV.SUBTOTAL * V.IGV / 100), 2) AS 'TOTAL_PAGAR'
        FROM DETALLEVENTA DV
        INNER JOIN VENTA V ON V.ID_VENTA = DV.ID_VENTA
        INNER JOIN PRODUCTO P ON P.ID_PRODUCTO = DV.ID_PRODUCTO
        WHERE DV.ID_VENTA = 1;";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_venta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerVentaPorId($id_venta)
    {
        $sql = "";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_venta]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
