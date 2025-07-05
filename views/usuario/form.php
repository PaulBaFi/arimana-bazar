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
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <form action="index.php?controller=usuario&action=<?= isset($usuario) ? 'update' : 'store' ?>"
                        method="POST">
                        <?php if (isset($usuario)): ?>
                            <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="personaId">Empleado *</label>
                            <select id="personaId" name="id_persona" required>
                                <option value="">—Seleccione un empleado—</option>
                                <?php foreach ($personas as $persona): ?>
                                    <option value="<?= $persona['id_persona'] ?>"
                                        <?= (isset($usuario) && $usuario['id_persona'] == $persona['id_persona']) ? 'selected' : '' ?>>
                                        <?= $persona['nombres'] . ' ' . $persona['apellidos'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo Electrónico *</label>
                            <input type="email" id="correo" name="correo" required maxlength="50"
                                value="<?= isset($usuario) ? $usuario['correo'] : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="clave">Contraseña *</label>
                            <input type="password" id="clave" name="clave" required maxlength="25"
                                value="<?= isset($usuario) ? $usuario['clave'] : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="rol">Rol *</label>
                            <select id="rol" name="rol" required>
                                <option value="administrador"
                                    <?= (isset($usuario) && $usuario['rol'] === 'administrador') ? 'selected' : '' ?>>
                                    Administrador
                                </option>
                                <option value="gerente"
                                    <?= (isset($usuario) && $usuario['rol'] === 'gerente') ? 'selected' : (!isset($usuario) ? 'selected' : '') ?>>
                                    Gerente
                                </option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <a href="index.php?controller=usuario&action=index" class="btn">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <?= isset($usuario) ? "Actualizar" : "Guardar" ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>