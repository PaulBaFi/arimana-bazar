<aside class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <input type="checkbox" id="Proveedor" class="menu-item-check">
            <label class="sidebar-title" for="Proveedor">
                <span>Proveedores</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>
            <ul class="submenu">
                <li>
                    <a href="index.php?controller=proveedor&action=index" class="menu-item-link">Listar
                        Proveedores</a>
                </li>
                <li>
                    <a href="" class="menu-item-link">Buscar Proveedores</a>
                </li>
            </ul>
        </li>

        <li>
            <input type="checkbox" id="pedidos" class="menu-item-check" checked>
            <label class="sidebar-title" for="pedidos">
                <span>Pedidos</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>

            <ul class="submenu">
                <li>
                    <a href="index.php?controller=pedido&action=index" class="menu-item-link">Listar pedidos</a>
                </li>
                <li>
                    <a href="index.php?controller=pedido&action=create" class="menu-item-link active">Crear pedido</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Gestión de Pedidos</h1>
            <p>Administra los pedidos realizados a proveedores</p>
        </header>

        <div class="main-content">
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <form action="index.php?controller=pedido&action=create" method="POST" id="pedidoForm">
                        <div class="form-col1">
                            <div class="form-group">
                                <label>Proveedor *</label>
                                <select name="proveedorId" required>
                                    <option value="">Seleccione un proveedor</option>
                                    <?php foreach ($proveedores as $p): ?>
                                        <option value="<?= $p['id_proveedor'] ?>"><?= htmlspecialchars($p['razonsocial']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Observación</label>
                                <textarea name="observacion" maxlength="200"
                                    placeholder="Ingrese alguna observación"></textarea>
                            </div>

                            <div class="col-section">
                                <h4>Productos</h4>
                                <button type="button" class="btn btn-primary" onclick="addDetalle()">Agregar
                                    Producto</button>
                            </div>

                            <div class="total-section">
                                <div class="total-display">
                                    <strong>Total del Pedido: S/ <span id="totalPedido">0.00</span></strong>
                                </div>
                            </div>
                        </div>

                        <div id="detallesContainer"></div>

                        <div class="form-actions">
                            <a href="index.php?controller=pedido&action=index" class="btn">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <?= isset($pedido) ? "Actualizar" : "Generar pedido" ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    const productos = <?= json_encode($productos) ?>;
    let index = 0;

    function addDetalle() {
        const container = document.getElementById("detallesContainer");

        const div = document.createElement("div");
        div.className = "detalle-item";
        div.innerHTML = `
            <select name="detalles[${index}][id_producto]" class="producto-select" required>
                <option value="">Seleccione un producto</option>
                ${productos.map(p =>
                    `<option value="${p.id_producto}" data-precio="${p.precio}">${p.nom_prod} - S/ ${p.precio}</option>`
                ).join('')}
            </select>
            <input type="number" name="detalles[${index}][cantidad]" class="cantidad-input" min="1" placeholder="Cantidad" required>
            <button type="button" class="btn btn-delete" onclick="this.parentNode.remove(); calcularTotal();">
                <i class="fa-solid fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
        index++;
        calcularTotal();
        div.querySelector('.producto-select').addEventListener('change', calcularTotal);
        div.querySelector('.cantidad-input').addEventListener('input', calcularTotal);
    }

    document.getElementById('pedidoForm').addEventListener('submit', function(e) {
        const cantidades = document.querySelectorAll('input[name*="[cantidad]"]');
        let valid = true;
        cantidades.forEach(input => {
            if (parseInt(input.value) <= 0 || isNaN(input.value)) {
                input.style.border = "2px solid red";
                valid = false;
            } else {
                input.style.border = "";
            }
        });
        if (!valid) {
            e.preventDefault();
            alert("Todas las cantidades deben ser mayores a cero.");
        }
    });

    function calcularTotal() {
        let total = 0;
        const items = document.querySelectorAll('.detalle-item');

        items.forEach(item => {
            const select = item.querySelector('.producto-select');
            const cantidadInput = item.querySelector('.cantidad-input');

            const selectedOption = select.options[select.selectedIndex];
            const precio = parseFloat(selectedOption.getAttribute('data-precio')) || 0;
            const cantidad = parseInt(cantidadInput.value) || 0;

            if (cantidad > 0 && precio > 0) {
                total += precio * cantidad;
            }
        });

        document.getElementById('totalPedido').innerText = total.toFixed(2);
    }
</script>