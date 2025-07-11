<aside class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <input type="checkbox" id="cliente" class="menu-item-check">
            <label class="sidebar-title" for="cliente">
                <span>Clientes</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>
            <ul class="submenu">
                <li>
                    <a href="index.php?controller=cliente&action=index" class="menu-item-link">Listar
                        clientes</a>
                </li>
                <li>
                    <a href="" class="menu-item-link">Buscar clientes</a>
                </li>
            </ul>
        </li>

        <li>
            <input type="checkbox" id="ventas" class="menu-item-check" checked>
            <label class="sidebar-title" for="ventas">
                <span>Ventas</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>

            <ul class="submenu">
                <li>
                    <a href="index.php?controller=venta&action=index" class="menu-item-link">Listar ventas</a>
                </li>
                <li>
                    <a href="index.php?controller=venta&action=create" class="menu-item-link active">Crear venta</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Registrar nueva venta</h1>
            <p>Completa los campos para registrar una venta</p>
        </header>

        <div class="main-content">
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <form method="POST" action="index.php?controller=venta&action=store"
                        onsubmit="return prepararDatosVenta()" id="formVenta">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="cliente">Cliente</label>
                                <select id="cliente" name="clienteId" required>
                                    <option value="">Seleccione un cliente</option>
                                    <?php foreach ($clientes as $c): ?>
                                    <option value="<?= $c['id_cliente'] ?>"><?= $c['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="documento">Documento</label>
                                <select name="documento" id="documento" required>
                                    <option value="F">Factura</option>
                                    <option value="B">Boleta</option>
                                </select>
                            </div>

                            <div class="form-group full">
                                <label for="observacion">Observación</label>
                                <textarea name="observacion" id="observacion" rows="2"></textarea>
                            </div>

                            <div class="totales">
                                <div class="totales-text">
                                    <p><strong>IGV (18%):</strong> S/ <span id="igv">0.00</span></p>
                                    <p><strong>Total:</strong> S/ <span id="total">0.00</span></p>
                                </div>

                                <button type="button" class="btn btn-secondary" onclick="agregarFila()">Agregar
                                    producto</button>
                            </div>
                        </div>

                        <div class="productos-venta">
                            <table class="base-table" id="tablaDetalle">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="detalleVentaBody">
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="detalles" id="detallesJSON">

                        <div class="form-actions">
                            <a href="index.php?controller=venta&action=index" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar venta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>


<script>
const productos = <?= json_encode($productos) ?>;
let contador = 0;

function agregarFila() {
    const fila = document.createElement('tr');
    const idFila = contador++;

    fila.innerHTML = `
            <td>
                <select name="producto" onchange="actualizarPrecio(${idFila}, this)">
                    <option value="">Seleccione</option>
                    ${productos.map(p => `<option value="${p.id_producto}" data-precio="${p.precio}">${p.nom_prod}</option>`).join('')}
                </select>
            </td>
            <td><input type="text" name="precio" id="precio_${idFila}" readonly value="0.00" /></td>
            <td><input type="number" name="cantidad" id="cantidad_${idFila}" min="1" value="1" onchange="calcularSubtotal(${idFila})" /></td>
            <td><input type="text" name="subtotal" id="subtotal_${idFila}" readonly value="0.00" /></td>
            <td><button type="button" onclick="eliminarFila(this)">
                <i class="fa-solid fa-trash"></i>
            </button></td>
    `;

    document.getElementById('detalleVentaBody').appendChild(fila);
}

function actualizarPrecio(id, select) {
    const precio = parseFloat(select.selectedOptions[0].dataset.precio || 0);
    document.getElementById(`precio_${id}`).value = precio.toFixed(2);
    calcularSubtotal(id);
}

function calcularSubtotal(id) {
    const precio = parseFloat(document.getElementById(`precio_${id}`).value || 0);
    const cantidad = parseInt(document.getElementById(`cantidad_${id}`).value || 0);
    const subtotal = precio * cantidad;

    document.getElementById(`subtotal_${id}`).value = subtotal.toFixed(2);
    calcularTotales();
}

function calcularTotales() {
    let total = 0;
    document.querySelectorAll('[id^="subtotal_"]').forEach(input => {
        total += parseFloat(input.value || 0);
    });

    const igv = total * 0.18;
    document.getElementById('igv').innerText = igv.toFixed(2);
    document.getElementById('total').innerText = (total + igv).toFixed(2);
}

function eliminarFila(btn) {
    btn.closest('tr').remove();
    calcularTotales();
}

function prepararDatosVenta() {
    const detalles = [];

    document.querySelectorAll('#detalleVentaBody tr').forEach(fila => {
        const select = fila.querySelector('select[name="producto"]');
        const id_producto = parseInt(select.value);
        const cantidad = parseInt(fila.querySelector('input[name="cantidad"]').value);
        if (!id_producto || !cantidad) return;

        detalles.push({
            id_producto,
            cantidad
        });
    });

    if (detalles.length === 0) {
        alert('Agregue al menos un producto.');
        return false;
    }

    console.log("DETALLES A ENVIAR:", detalles);

    document.getElementById('detallesJSON').value = JSON.stringify(detalles);
    return true;
}
</script>