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
            <p>Administra las ventas realizadas a clientes</p>
        </header>

        <div class="main-content">
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" id="searchInput"
                        placeholder="Buscar ventas por cliente, usuario o fecha de venta...">
                </div>
                <a href="index.php?controller=venta&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Nueva venta
                </a>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table" id="pedidosTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Observación</th>
                                <th>Productos</th>
                                <th>Documento</th>
                                <th>IGV (%)</th>
                                <th>Fecha Venta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pedidos)): ?>
                                <tr>
                                    <td colspan="11" class="no-registros">No hay ventas registradas.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td><?= $pedido['id_pedido'] ?></td>
                                        <td>
                                            <?= htmlspecialchars($pedido['usuario']) ?>
                                            <span class="user-badge user-<?= $pedido['rol'] ?>">
                                                <?php if (strtolower($pedido['rol']) === 'administrador'): ?>
                                                    ADMIN
                                                <?php else: ?>
                                                    GERENTE
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($pedido['proveedor']) ?></td>
                                        <td><span class="total-badge">S/ <?= number_format($pedido['total_pagar'], 2) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($pedido['observacion']) ?></td>
                                        <td>
                                            <span class="productos-count">
                                                <?= $pedido['total_productos'] ?> unidades
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($pedido['fecha_pedido']) ?></td>
                                        <td>
                                            <div class="actions">
                                                <button class="btn btn-sm btn-info ver-detalle-pedido" title="Ver detalles"
                                                    data-id="<?= $pedido['id_pedido'] ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <a href="index.php?controller=pedido&action=edit&id=<?= $pedido['id_pedido'] ?>"
                                                    class="btn btn-sm btn-edit" title="Editar">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>

                                                <a href="index.php?controller=pedido&action=delete&id=<?= $pedido['id_pedido'] ?>"
                                                    class="btn btn-sm btn-delete btn-delete-pedido">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
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
            <h3>Detalles del Pedido #1</h3>
            <menu><button><i class="fa-solid fa-xmark"></i></button></menu>
        </div>
        <div id="contenidoDetalle"></div>
    </form>
</dialog>

<script>
    document.querySelectorAll(".ver-detalle-pedido").forEach(btn => {
        btn.addEventListener("click", async function() {
            const id = this.dataset.id;

            const res = await fetch(`ajax/pedido_detalle.php?id_pedido=${id}`);
            const html = await res.text();

            document.querySelector("#modalDetalle h3").innerText = `Detalles del Pedido #${id}`;
            document.querySelector("#contenidoDetalle").innerHTML = html;

            document.getElementById("modalDetalle").showModal();
        });
    });
</script>