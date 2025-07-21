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
                    <a href="index.php?controller=venta&action=index" class="menu-item-link active">Listar ventas</a>
                </li>
                <li>
                    <a href="index.php?controller=venta&action=create" class="menu-item-link">Crear venta</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Gestión de Ventas</h1>
            <p>Administra las ventas realizadas a los clientes</p>
        </header>

        <div class="main-content">
            <div class="toolbar">
                <a href="index.php?controller=venta&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Nueva venta
                </a>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table" id="ventasTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Usuario</th>
                                <th>Documento</th>
                                <th>IGV</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($ventas)): ?>
                                <tr>
                                    <td colspan="8" class="no-registros">No hay personas registradas.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($ventas as $venta): ?>
                                    <tr>
                                        <td><?= $venta['id_venta'] ?></td>
                                        <td><?= htmlspecialchars($venta['cliente']) ?></td>
                                        <td>
                                            <?= htmlspecialchars($venta['usuario']) ?>
                                            <span class="<?= 'user-badge user-' . strtolower($venta['rol']) ?>">
                                                <?php if (strtolower($venta['rol']) === 'administrador'): ?>
                                                    ADMIN
                                                <?php else: ?>
                                                    EMPLEADO
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="<?= 'documento documento-' . strtolower($venta['documento']) ?>">
                                                <?= $venta['documento'] ?>
                                            </span>
                                        </td>
                                        <td>S/ <?= number_format($venta['igv'], 2) ?></td>
                                        <td><span class="total-badge">S/ <?= number_format($venta['total_pagar'], 2) ?></span>
                                        </td>
                                        <td><?= $venta['fecha_venta'] ?></td>
                                        <td>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-info ver-detalle-venta"
                                                    data-id="<?= $venta['id_venta'] ?>">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<dialog id="modalDetalle">
    <form method="dialog" style="width: 100%;">
        <div class="modal-header">
            <h3>Detalles de la Venta #<span id="ventaId"></span></h3>
            <menu><button><i class="fa-solid fa-xmark"></i></button></menu>
        </div>
        <div id="contenidoDetalleVenta">
            <!-- Aquí se cargan dinámicamente los datos -->
        </div>
    </form>
</dialog>

<script>
    document.querySelectorAll(".ver-detalle-venta").forEach(btn => {
        btn.addEventListener("click", async function() {
            const id = this.dataset.id;

            const res = await fetch(`ajax/venta_detalle.php?id=${id}`);
            const html = await res.text();

            document.getElementById("ventaId").innerText = id;
            document.getElementById("contenidoDetalleVenta").innerHTML = html;

            document.getElementById("modalDetalle").showModal();
        });
    });
</script>