<aside class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <input type="checkbox" id="Proveedor" class="menu-item-check" checked>
            <label class="sidebar-title" for="Proveedor">
                <span>Proveedores</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>
            <ul class="submenu">
                <li>
                    <a href="index.php?controller=proveedor&action=index" class="menu-item-link active">Listar
                        Proveedores</a>
                </li>
                <li>
                    <a href="" class="menu-item-link">Buscar Proveedores</a>
                </li>
            </ul>
        </li>

        <li>
            <input type="checkbox" id="pedidos" class="menu-item-check">
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
                    <a href="index.php?controller=pedido&action=create" class="menu-item-link">Crear pedido</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Gestión de Proveedores</h1>
            <p>Administra los proveedores registrados en el sistema</p>
        </header>

        <div class="main-content">
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" id="searchInput"
                        placeholder="Buscar proveedores por razón social, RUC o descripción...">
                </div>
                <a href="index.php?controller=proveedor&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Agregar proveedor
                </a>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table" id="proveedoresTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Razón Social</th>
                                <th>RUC</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($proveedores)): ?>
                                <tr>
                                    <td colspan="8" class="no-registros">No hay proveedores registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($proveedores as $proveedor): ?>
                                    <tr class="<?= 'estado-' . $proveedor['estado'] ?>">
                                        <td><?= $proveedor['id_proveedor'] ?></td>
                                        <td><?= $proveedor['razonsocial'] ?></td>
                                        <td><?= $proveedor['ruc'] ?></td>
                                        <td><?= $proveedor['correo'] ?></td>
                                        <td><?= $proveedor['telefono'] ?></td>
                                        <td><?= $proveedor['direccion'] ?></td>
                                        <td><?= $proveedor['fecha_registro'] ?></td>
                                        <td>
                                            <?php if ($proveedor['estado'] == 1): ?>
                                                <div class="actions">
                                                    <a href="index.php?controller=proveedor&action=edit&id=<?= $proveedor['id_proveedor'] ?>"
                                                        class="btn btn-sm btn-edit">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </a>

                                                    <a href="index.php?controller=proveedor&action=delete&id=<?= $proveedor['id_proveedor'] ?>"
                                                        class="btn btn-sm btn-delete btn-delete-proveedor"
                                                        data-id="<?= $proveedor['id_proveedor'] ?>">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <span class="status-badge status-inactive">Inactivo</span>
                                            <?php endif; ?>
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

<script>
    document.querySelectorAll(".btn-delete-proveedor").forEach(button => {
        button.addEventListener("click", async function(e) {
            e.preventDefault();

            const url = this.getAttribute("href");

            const result = await Swal.fire({
                title: "¿Desea eliminar al proveedor?",
                text: "Esta acción es irreversible.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6"
            });

            if (result.isConfirmed) {
                await Swal.fire({
                    icon: "success",
                    title: "Eliminado correctamente",
                    timer: 1500,
                    showConfirmButton: false
                });

                window.location.href = url;
            }
        });
    });
</script>