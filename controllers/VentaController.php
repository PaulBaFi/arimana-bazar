<?php
require_once "models/VentaModel.php";

class VentaController
{
    private $model;

    public function __construct()
    {
        $this->model = new VentaModel();
    }

    public function index()
    {
        $ventas = $this->model->getAll();
        include 'views/ventas/index.php';
    }

    public function create()
    {
        $clientes = $this->model->obtenerClientes();
        $productos = $this->model->obtenerProductos();
        include 'views/ventas/form.php';
    }

    public function store($post)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
            die("Sesión no iniciada.");
        }

        $idUsuario = $_SESSION['usuario']['id'];

        $venta = [
            'id_usuario' => $idUsuario,
            'id_cliente' => $post['clienteId'],
            'observacion' => $post['observacion'],
            'documento' => $post['documento'],
            'igv' => 0,
            'total_pagar' => 0,
            'fecha_venta' => date('Y-m-d')
        ];

        $idVenta = $this->model->insertarVenta($venta);

        $detalles = json_decode($post['detalles'], true);

        if (!is_array($detalles) || empty($detalles)) {
            die("No se puede registrar una venta sin productos.");
        }

        $total = 0;

        foreach ($detalles as $d) {
            $producto = $this->model->obtenerProductoPorId($d['id_producto']);
            $precio = $producto['precio'];
            $cantidad = (int)$d['cantidad'];
            $subtotal = $precio * $cantidad;
            $total += $subtotal;

            $this->model->insertarDetalle([
                'id_venta' => $idVenta,
                'id_producto' => $d['id_producto'],
                'cantidad' => $cantidad,
                'subtotal' => $subtotal
            ]);
        }

        $igv = $total * 0.18;
        $totalPagar = $total + $igv;

        $this->model->actualizarTotalVenta($idVenta, $igv, $totalPagar);

        header('Location: index.php?controller=venta&action=index');
        exit;
    }

    public function detalle()
    {
        $id = $_GET['id'] ?? 0;
        $venta = $this->model->getById($id);
        $detalles = $this->model->getDetalle($id);
        include 'views/ventas/detalle.php';
    }
}
