<?php
require_once __DIR__ . '/conexion.php';


class VentaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::conectar();
    }

    public function getAll()
    {
        $sql = "SELECT V.id_venta as id_venta,
            V.id_usuario AS id_usuario,
            V.id_cliente AS id_cliente,
            V.observacion AS observacion,
            V.igv AS igv,
            V.total_pagar AS total_pagar,
            V.fecha_venta AS fecha_venta,
            CASE WHEN V.documento = 'B' THEN 'Boleta' ELSE 'Factura' END AS documento,
            COALESCE(CONCAT(P.nombres, ' ', P.apellidos), E.razonsocial) AS cliente,
            U.rol, CONCAT(PU.nombres, ' ', PU.apellidos) AS usuario
        FROM Venta V
        LEFT JOIN Cliente C ON V.id_cliente = C.id_cliente
        LEFT JOIN EMpresa E ON C.id_empresa = E.id_empresa
        LEFT JOIN Persona P ON C.id_persona = P.id_persona
        LEFT JOIN Usuario U ON V.id_usuario = U.id_usuario
        LEFT JOIN Persona PU ON U.id_persona = PU.id_persona
        ORDER BY V.fecha_venta DESC;";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT id_venta as id_venta,
                id_usuario AS id_usuario,
                id_cliente AS id_cliente,
                observacion AS observacion,
                CASE WHEN documento = 'B' THEN 'Boleta' 
                    ELSE 'Factura' END AS documento,
                igv AS igv,
                total_pagar AS total_pagar,
                fecha_venta AS fecha_venta
            FROM Venta WHERE id_venta = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDetalle($id_venta)
    {
        $sql = "SELECT DP.*, P.nom_prod, P.precio 
                FROM DetalleVenta DP
                INNER JOIN Producto P ON DP.id_producto = P.id_producto
                WHERE DP.id_venta = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_venta]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertarVenta($data)
    {
        // Asigna el ID del usuario desde la sesión
        $data['id_usuario'] = $_SESSION['usuario']['id'];

        $sql = "INSERT INTO Venta (id_usuario, id_cliente, observacion, documento, igv, total_pagar, fecha_venta)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        // Ejecutar la consulta con los valores correctos
        $stmt->execute([
            $data['id_usuario'],
            $data['id_cliente'],
            $data['observacion'],
            $data['documento'],
            $data['igv'],
            $data['total_pagar'],
            $data['fecha_venta']
        ]);

        // Devolver el ID de la venta insertada, si lo necesitas
        return $this->db->lastInsertId();
    }

    public function insertarDetalle($detalle)
    {
        $sql = "INSERT INTO DetalleVenta (id_venta, id_producto, cantidad, subtotal)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $detalle['id_venta'],
            $detalle['id_producto'],
            $detalle['cantidad'],
            $detalle['subtotal']
        ]);
    }

    public function actualizarTotalVenta($idVenta, $igv, $totalPagar)
    {
        $sql = "UPDATE Venta SET igv = ?, total_pagar = ? WHERE id_venta = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$igv, $totalPagar, $idVenta]);
    }

    public function obtenerClientes()
    {
        return $this->db->query("SELECT C.id_cliente, 
            COALESCE(CONCAT(P.nombres, ' ', P.apellidos), E.razonsocial) AS nombre
            FROM Cliente C
            LEFT JOIN Persona P ON C.id_persona = P.id_persona
            LEFT JOIN Empresa E ON C.id_empresa = E.id_empresa
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductos()
    {
        return $this->db->query("SELECT * FROM Producto WHERE estado = '1'")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Producto WHERE id_producto = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


/*
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
} */