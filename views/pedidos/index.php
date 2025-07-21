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
                    <a href="index.php?controller=pedido&action=index" class="menu-item-link active">Listar pedidos</a>
                </li>
                <li>
                    <a href="index.php?controller=pedido&action=create" class="menu-item-link">Crear pedido</a>
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
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" id="searchInput"
                        placeholder="Buscar pedidos por proveedor, usuario u observación...">
                </div>
                <a href="index.php?controller=pedido&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Nuevo pedido
                </a>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table" id="pedidosTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Proveedor</th>
                                <th>Total</th>
                                <th>Observación</th>
                                <th>Productos</th>
                                <th>Fecha Pedido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pedidos)): ?>
                                <tr>
                                    <td colspan="8" class="no-registros">No hay pedidos registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td><?= $pedido['id_pedido'] ?></td>
                                        <td>
                                            <?= htmlspecialchars($pedido['usuario']) ?>
                                            <span class="user-badge <?= 'user-' . strtolower($pedido['rol']) ?>">
                                                <?php if (strtolower($pedido['rol']) === 'administrador'): ?>
                                                    ADMIN
                                                <?php else: ?>
                                                    EMPLEADO
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