<aside class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <input type="checkbox" id="colaboradores" class="menu-item-check" checked>
            <label class="sidebar-title" for="colaboradores">
                <span>Colaboradores</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>
            <ul class="submenu">
                <li>
                    <a href="index.php?controller=persona&action=index" class="menu-item-link">Añadir
                        persona</a>
                </li>
                <li>
                    <a href="index.php?controller=empresa&action=index" class="menu-item-link active">Añadir
                        empresa</a>
                </li>
            </ul>
        </li>

        <li>
            <input type="checkbox" id="usuarios" class="menu-item-check">
            <label class="sidebar-title" for="usuarios">
                <span>Usuarios</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>
            <ul class="submenu">
                <li>
                    <a href="index.php?controller=usuario&action=index" class="menu-item-link">Añadir
                        usuario</a>
                </li>
                <li>
                    <a href="" class="menu-item-link">Buscar
                        usuario</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>


<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Gestión de Empresas</h1>
            <p>Administra la información de las empresas registradas</p>
        </header>

        <div class="main-content">
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" id="searchInput"
                        placeholder="Buscar empresas por razón social, RUC, correo o teléfono...">
                </div>

                <a href="index.php?controller=empresa&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Registrar empresa
                </a>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table " id="personsTable">
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
                            <?php if (empty($empresas)): ?>
                                <tr>
                                    <td colspan="8" class="no-registros">No hay empresas registradas.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($empresas as $empresa): ?>
                                    <tr class="<?= 'estado-' . $empresa['estado'] ?>">
                                        <td><?= $empresa['id_empresa'] ?></td>
                                        <td><?= $empresa['razonsocial']  ?></td>
                                        <td><?= $empresa['ruc'] ?></td>
                                        <td><?= $empresa['correo'] ?></td>
                                        <td><?= $empresa['telefono'] ?></td>
                                        <td><?= $empresa['direccion'] ?></td>
                                        <td><?= $empresa['fecha_registro'] ?></td>
                                        <td>
                                            <?php if ($empresa['estado'] == 1): ?>
                                                <div class="actions">
                                                    <a href="index.php?controller=empresa&action=edit&id=<?= $empresa['id_empresa'] ?>"
                                                        class="btn btn-sm btn-edit">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </a>
                                                    <a href="index.php?controller=empresa&action=delete&id=<?= $empresa['id_empresa'] ?>"
                                                        class="btn btn-sm btn-delete btn-delete-empresa"
                                                        data-id="<?= $cliente['id_cliente'] ?>">
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
    document.querySelectorAll(".btn-delete-empresa").forEach(button => {
        button.addEventListener("click", async function(e) {
            e.preventDefault();

            const url = this.getAttribute("href");

            const result = await Swal.fire({
                title: "¿Desea eliminar a la empresa?",
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