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
            <h1><?= isset($persona) ? "Editar Persona" : "Registrar persona" ?></h1>
        </header>

        <div class="main-content">
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <form action="index.php?controller=persona&action=<?= isset($persona) ? 'update' : 'store' ?>"
                        method="POST">
                        <?php if (isset($persona)): ?>
                            <input type="hidden" name="id_persona" value="<?= $persona['id_persona'] ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="nombres" class="form-label">Nombres:</label>
                            <input type="text" class="form-control" name="nombres" required
                                value="<?= $persona['nombres'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" name="apellidos" required
                                value="<?= $persona['apellidos'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="dni" class="form-label">DNI:</label>
                            <input type="number" class="form-control" name="dni" maxlength="8" required
                                value="<?= $persona['dni'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" name="correo" required
                                value="<?= $persona['correo'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="tel" class="form-control" name="telefono" maxlength="9"
                                value="<?= $persona['telefono'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" name="direccion"
                                value="<?= $persona['direccion'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="nacimiento" class="form-label">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="nacimiento"
                                value="<?= $persona['nacimiento'] ?? '' ?>">
                        </div>

                        <div class="form-actions">
                            <a href="index.php?controller=persona&action=index" class="btn">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <?= isset($persona) ? "Actualizar" : "Guardar" ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>