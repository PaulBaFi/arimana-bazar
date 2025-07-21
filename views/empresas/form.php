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
            <h1><?= isset($empresa) ? "Editar empresa" : "Registrar empresa" ?></h1>
        </header>

        <div class="main-content">
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <form action="index.php?controller=empresa&action=<?= isset($empresa) ? 'update' : 'store' ?>"
                        method="POST">
                        <?php if (isset($empresa)): ?>
                            <input type="hidden" name="id_empresa" value="<?= $empresa['id_empresa'] ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="razonsocial" class="form-label">Razón social:</label>
                            <input type="text" class="form-control" name="razonsocial" required
                                value="<?= $empresa['razonsocial'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="ruc" class="form-label">RUC:</label>
                            <input type="number" class="form-control" name="ruc" maxlength="11" required
                                value="<?= $empresa['ruc'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" name="correo" required
                                value="<?= $empresa['correo'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="tel" class="form-control" name="telefono" maxlength="9"
                                value="<?= $empresa['telefono'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" name="direccion"
                                value="<?= $empresa['direccion'] ?? '' ?>">
                        </div>

                        <div class="form-actions">
                            <a href="index.php?controller=empresa&action=index" class="btn">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <?= isset($empresa) ? "Actualizar" : "Guardar" ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>