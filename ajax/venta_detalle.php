<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', realpath(__DIR__ . "/.."));
}

require_once BASE_PATH . '/models/VentaModel.php';

$model = new VentaModel();

$id = $_GET['id'] ?? 0;

$venta = $model->getById($id);
$detalles = $model->getDetalle($id);

if (!$venta) {
    echo "<p>Venta no encontrada.</p>";
    exit;
}

?>

<p><strong>Documento:</strong> <?= $venta['documento'] ?></p>
<p><strong>Observación:</strong> <?= $venta['observacion'] ?></p>
<p><strong>Fecha:</strong> <?= $venta['fecha_venta'] ?></p>
<p><strong>IGV:</strong> S/ <?= number_format($venta['igv'], 2) ?></p>

<table cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>PRODUCTO</th>
            <th>CANTIDAD</th>
            <th>PRECIO UNIT.</th>
            <th>SUBTOTAL</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; ?>
        <?php foreach ($detalles as $d): ?>
            <?php $subtotal = $d['cantidad'] * $d['precio']; ?>
            <tr>
                <td><?= $d['nom_prod'] ?></td>
                <td><?= $d['cantidad'] ?></td>
                <td>S/ <?= number_format($d['precio'], 2) ?></td>
                <td>S/ <?= number_format($subtotal, 2) ?></td>
            </tr>
            <?php $total += $subtotal; ?>
        <?php endforeach ?>
    </tbody>
</table>

<p class="total"><strong>Total a pagar:</strong> S/ <?= number_format($total + $venta['igv'], 2) ?></p>