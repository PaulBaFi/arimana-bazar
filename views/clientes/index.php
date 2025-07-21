<aside class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <input type="checkbox" id="cliente" class="menu-item-check" checked>
            <label class="sidebar-title" for="cliente">
                <span>Clientes</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>
            <ul class="submenu">
                <li>
                    <a href="index.php?controller=cliente&action=index" class="menu-item-link active">Listar
                        clientes</a>
                </li>
                <li>
                    <a href="" class="menu-item-link">Buscar clientes</a>
                </li>
            </ul>
        </li>

        <li>
            <input type="checkbox" id="ventas" class="menu-item-check">
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
                    <a href="index.php?controller=venta&action=create" class="menu-item-link">Crear venta</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Gestión de clientes</h1>
            <p>Administra la información de los clientes registradas.</p>
        </header>

        <div class="main-content">
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Buscar clientes por DNI o nombre ...">
                </div>

                <button class="btn btn-primary" id="openModalCliente">
                    <i class="fa-solid fa-plus"></i>
                    Registrar cliente
                </button>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table " id="clientesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Identificación</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($clientes)): ?>
                                <tr>
                                    <td colspan="7" class="no-registros">No hay clientes registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($clientes as $cliente): ?>
                                    <tr>
                                        <td><?= $cliente['id_cliente'] ?></td>
                                        <td><?= htmlspecialchars($cliente['nomcliente']) ?></td>
                                        <td><?= htmlspecialchars($cliente['documento']) ?></td>
                                        <td><?= htmlspecialchars($cliente['correo']) ?></td>
                                        <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                                        <td><?= htmlspecialchars($cliente['direccion']) ?></td>
                                        <td>
                                            <div class="actions">
                                                <a href="index.php?controller=cliente&action=form&id=<?= $cliente['id_cliente'] ?>"
                                                    class="btn btn-sm btn-edit" title="Editar">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>

                                                <a href="index.php?controller=cliente&action=delete&id=<?= $cliente['id_cliente'] ?>"
                                                    class="btn btn-sm btn-delete btn-delete-cliente"
                                                    data-id="<?= $cliente['id_cliente'] ?>">
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

<script>
    document.getElementById("openModalCliente").addEventListener("click", function() {
        Swal.fire({
            title: "Registrar cliente como...",
            html: `
                <div class="dialog-cards">
                    <a href="index.php?controller=cliente&action=form&tipo=persona" class="dialog-card">
                        <i class="fa-solid fa-user"></i>
                        Persona
                    </a>

                    <a href="index.php?controller=cliente&action=form&tipo=empresa" class="dialog-card">
                        <i class="fa-solid fa-building"></i>
                        Empresa
                    </a>
                </div>
            `,
            showConfirmButton: false,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
        });
    })

    document.querySelectorAll(".btn-delete-cliente").forEach(button => {
        button.addEventListener("click", async function(e) {
            e.preventDefault();

            const url = this.getAttribute("href");

            const result = await Swal.fire({
                title: "¿Desea eliminar al cliente?",
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