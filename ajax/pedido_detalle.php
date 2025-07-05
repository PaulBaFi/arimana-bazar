<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', realpath(__DIR__ . "/.."));
}

require_once BASE_PATH . '/models/PedidoModel.php';

// Verifica que se recibió el ID
if (!isset($_GET['id_pedido'])) {
    echo "<p>Error: Falta ID de pedido.</p>";
    exit;
}

$model = new PedidoModel();
$pedido = $model->obtenerPedidoPorId($_GET['id_pedido']);
$detalles = $model->obtenerDetallePedido($_GET['id_pedido']);

if (!$pedido) {
    echo "<p>Pedido no encontrado.</p>";
    exit;
}

// Contenido simple sin layout
echo "<p><strong>Usuario:</strong> " . htmlspecialchars($pedido['usuario']) . "</p>";
echo "<p><strong>Proveedor:</strong> " . htmlspecialchars($pedido['proveedor']) . "</p>";
echo "<p><strong>RUC:</strong> " . htmlspecialchars($pedido['ruc']) . "</p>";
echo "<p><strong>Dirección:</strong> " . htmlspecialchars($pedido['direccion']) . "</p>";
echo "<p><strong>Fecha:</strong> " . htmlspecialchars($pedido['fecha_pedido']) . "</p>";
echo "<p><strong>Observación:</strong> " . htmlspecialchars($pedido['observacion']) . "</p>";

if ($detalles) {
    echo "<table class='tabla-detalle'>
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
    echo "<p>No hay productos en este pedido.</p>";
}
