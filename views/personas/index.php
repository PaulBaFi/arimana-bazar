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
                    <a href="index.php?controller=persona&action=index" class="menu-item-link active">Añadir
                        persona</a>
                </li>
                <li>
                    <a href="index.php?controller=empresa&action=index" class="menu-item-link">Añadir
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
            <h1>Gestión de Personas</h1>
            <p>Administra la información de las personas registradas</p>
        </header>

        <div class="main-content">
            <div class="toolbar">
                <div class="search-box">
                    <form class="search-form" method="get" action="index.php?controller=persona&action=index">
                        <input type="hidden" name="controller" value="persona">
                        <input type="hidden" name="action" value="index">
                        <input type="text" id="searchInput" name="buscar"
                            placeholder="Buscar personas por nombre, dni o correo..."
                            value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">
                        <button type="submit" class="btn">Buscar</button>
                    </form>
                </div>

                <a href="index.php?controller=persona&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Registrar persona
                </a>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table " id="personsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>DNI</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Nacimiento</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($personas)): ?>
                                <tr>
                                    <td colspan="9" class="no-registros">No hay personas registradas.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($personas as $persona): ?>
                                    <tr class="<?= 'estado-' . $persona['estado'] ?>">
                                        <td><?= $persona['id_persona'] ?></td>
                                        <td><?= $persona['nombres'] . ' ' . $persona['apellidos'] ?></td>
                                        <td><?= $persona['dni'] ?></td>
                                        <td><?= $persona['correo'] ?></td>
                                        <td><?= $persona['telefono'] ?></td>
                                        <td><?= $persona['direccion'] ?></td>
                                        <td><?= $persona['nacimiento'] ?></td>
                                        <td><?= $persona['fecha_registro'] ?></td>
                                        <td>
                                            <?php if ($persona['estado'] == 1): ?>
                                                <div class="actions">
                                                    <a href="index.php?controller=persona&action=edit&id=<?= $persona['id_persona'] ?>"
                                                        class="btn btn-sm btn-edit">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </a>
                                                    <a href="index.php?controller=persona&action=delete&id=<?= $persona['id_persona'] ?>"
                                                        class="btn btn-sm btn-delete"
                                                        onclick="return confirm('¿Estás seguro de eliminar este registro?');">
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