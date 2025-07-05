<?php
require_once "models/PedidoModel.php";

class PedidoController
{
    private $model;

    public function __construct()
    {
        $this->model = new PedidoModel();
    }

    public function index()
    {
        $pedidos = $this->model->getAll();

        include 'views/pedidos/index.php';
    }

    public function create()
    {
        $usuarios = $this->model->obtenerUsuarios();
        $proveedores = $this->model->obtenerProveedores();
        $productos = $this->model->obtenerProductos();

        include 'views/pedidos/form.php';
    }

    public function store($post)
    {
        session_start();

        if (!isset($_SESSION['usuario_id'])) {
            die("No hay usuario autenticado.");
        }

        $idUsuario = $_SESSION['usuario_id'];

        // Total temporal = 0
        $pedido = [
            'id_usuario' => $idUsuario,
            'id_proveedor' => $post['proveedorId'],
            'total_pagar' => 0,
            'observacion' => $post['observacion'],
            'fecha_pedido' => date('Y-m-d') // Aunque igual se puede omitir si usas DEFAULT NOW() en la tabla
        ];

        $idPedido = $this->model->insertarPedido($pedido);

        $total = 0;
        foreach ($post['detalles'] as $d) {
            $producto = $this->model->obtenerProductoPorId($d['id_producto']);
            $precio = $producto['precio'];
            $cantidad = (int)$d['cantidad'];
            $subtotal = $precio * $cantidad;
            $total += $subtotal;

            $this->model->insertarDetalle([
                'id_pedido' => $idPedido,
                'id_producto' => $d['id_producto'],
                'cantidad' => $cantidad,
                'subtotal' => $subtotal
            ]);
        }

        $this->model->actualizarTotalPedido($idPedido, $total);

        header('Location: index.php?controller=pedido&action=index');
    }

    public function detalle()
    {
        if (!isset($_GET['id_pedido'])) {
            echo "<p>Error: ID de pedido no proporcionado.</p>";
            return;
        }

        $idPedido = $_GET['id_pedido'];

        // Obtener datos generales del pedido (usuario, proveedor, etc.)
        $pedido = $this->model->obtenerPedidoPorId($idPedido);

        // Obtener detalle de productos
        $detalles = $this->model->obtenerDetallePedido($idPedido);

        if (!$pedido) {
            echo "<p>Pedido no encontrado.</p>";
            return;
        }

        // Mostrar información general
        echo "<p><strong>Usuario:</strong> " . htmlspecialchars($pedido['usuario']) . "</p>";
        echo "<p><strong>Proveedor:</strong> " . htmlspecialchars($pedido['proveedor']) . "</p>";
        echo "<p><strong>Fecha:</strong> " . htmlspecialchars($pedido['fecha_pedido']) . "</p>";
        echo "<p><strong>Observación:</strong> " . htmlspecialchars($pedido['observacion']) . "</p>";

        // Mostrar productos
        if ($detalles) {
            echo "<table class='tabla-detalle' cellspacing='0' cellpadding='5'>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>";

            $total = 0;
            foreach ($detalles as $d) {
                echo "<tr>
                    <td>{$d['producto']}</td>
                    <td>{$d['cantidad']}</td>
                    <td>S/ " . number_format($d['precio'], 2) . "</td>
                    <td>S/ " . number_format($d['subtotal'], 2) . "</td>
                </tr>";
                $total += $d['subtotal'];
            }

            echo "</tbody></table>";
            echo "<p class='total'><strong>Total:</strong> S/ " . number_format($total, 2) . "</p>";
        } else {
            echo "<p>Este pedido no tiene productos registrados.</p>";
        }
    }
}
