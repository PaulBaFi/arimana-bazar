<aside class="sidebar">
    <ul class="sidebar-menu">
        <li class="">
            <a class="sidebar-title-simple active" href="index.php?controller=principal&action=index">Principal</a>
        </li>

        <li>
            <input type="checkbox" id="colaboradores" class="menu-item-check">
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
                    <a href="index.php?controller=empresa&action=index" class="menu-item-link">Añadir
                        empresa</a>
                </li>
            </ul>
        </li>

        <li>
            <input type="checkbox" id="usuarios" class="menu-item-check" checked>
            <label class="sidebar-title" for="usuarios">
                <span>Usuarios</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>
            <ul class="submenu">
                <li>
                    <a href="index.php?controller=usuario&action=index" class="menu-item-link active">Añadir
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
            <h1>Gestión de Usuarios</h1>
            <p>Administra los usuarios registrados en el sistema</p>
        </header>

        <div class="main-content">
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Buscar usuarios por nombre, correo o rol...">
                </div>

                <a href="index.php?controller=usuario&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Registrar usuario
                </a>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table" id="usuariosTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Empleado</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr class="<?= 'estado-' . $usuario['estado'] ?>">
                                    <td><?= $usuario['id_usuario'] ?></td>
                                    <td><?= $usuario['nombres'] . ' ' . $usuario['apellidos'] ?></td>
                                    <td><?= $usuario['dni'] ?></td>
                                    <td><?= $usuario['correo'] ?></td>
                                    <td>
                                        <span
                                            class="rol-badge <?= 'rol-' . $usuario['rol'] ?>"><?= $usuario['rol'] ?></span>
                                    </td>
                                    <td><?= $usuario['fecha_registro'] ?></td>
                                    <td>
                                        <?php if ($usuario['estado'] == 1): ?>
                                            <div class="actions">
                                                <a href="index.php?controller=usuario&action=edit&id=<?= $usuario['id_usuario'] ?>"
                                                    class="btn btn-sm btn-edit">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>

                                                <a href="index.php?controller=usuario&action=delete&id=<?= $usuario['id_usuario'] ?>"
                                                    class="btn btn-sm btn-delete btn-delete-user"
                                                    data-id="<?= $usuario['id_usuario'] ?>">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <span class="status-badge status-inactive">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    <?php if (isset($_GET['msg'])): ?>
        <?php
        $msg = $_GET['msg'];
        $text = $msg === 'creado' ? 'Usuario registrado correctamente.'
            : ($msg === 'actualizado' ? 'Usuario actualizado correctamente.'
                : '');
        ?>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '<?= $text ?>',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        }).then(() => {
            window.location.href = "index.php?controller=usuario&action=index";
        });
    <?php endif; ?>

    document.querySelectorAll(".btn-delete-user").forEach(button => {
        button.addEventListener("click", async function(e) {
            e.preventDefault();

            const url = this.getAttribute("href");

            const result = await Swal.fire({
                title: "¿Desea eliminar al usuario?",
                text: "El usuario cambiará su estado a inactivo.",
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