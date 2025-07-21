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
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <?php
                    $isEdit = isset($cliente);
                    $tipo = '';

                    if ($isEdit && isset($cliente['tipo_cliente'])) {
                        $tipo = $cliente['tipo_cliente'];
                    } elseif (!$isEdit && isset($_GET['tipo'])) {
                        $tipo = $_GET['tipo'];
                    }

                    $action = $isEdit ? 'update' : 'store';
                    ?>

                    <form action="index.php?action=<?= $action ?>&controller=cliente" method="POST">
                        <?php if ($isEdit): ?>
                            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
                            <input type="hidden" name="tipo_cliente" value="<?= $tipo ?>">
                            <?php if ($tipo === 'persona'): ?>
                                <input type="hidden" name="id_persona" value="<?= $cliente['id_persona'] ?>">
                            <?php elseif ($tipo === 'empresa'): ?>
                                <input type="hidden" name="id_empresa" value="<?= $cliente['id_empresa'] ?>">
                            <?php endif; ?>
                        <?php else: ?>
                            <input type="hidden" name="tipo_cliente" value="<?= $tipo ?>">
                        <?php endif; ?>

                        <?php if (!$isEdit): ?>
                            <?php if ($tipo === 'persona'): ?>
                                <div class="form-group">
                                    <label for="id_persona">Selecciona una persona existente:</label>
                                    <select name="id_persona" id="id_persona" required>
                                        <option value="">-- Selecciona --</option>
                                        <?php foreach ($personas as $p): ?>
                                            <option value="<?= $p['id_persona'] ?>">
                                                <?= $p['nombres'] . ' ' . $p['apellidos'] . ' - DNI: ' . $p['dni'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            <?php elseif ($tipo === 'empresa'): ?>
                                <div class="form-group">
                                    <label for="id_empresa">Selecciona una empresa existente:</label>
                                    <select name="id_empresa" id="id_empresa" required>
                                        <option value="">-- Selecciona --</option>
                                        <?php foreach ($empresas as $e): ?>
                                            <option value="<?= $e['id_empresa'] ?>">
                                                <?= $e['razonsocial'] . ' - RUC: ' . $e['ruc'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <?php if ($tipo === 'persona'): ?>
                                <div class="form-group">
                                    <label>Nombres:</label>
                                    <input type="text" name="nombres" value="<?= $cliente['nombres'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Apellidos:</label>
                                    <input type="text" name="apellidos" value="<?= $cliente['apellidos'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>DNI:</label>
                                    <input type="text" name="dni" value="<?= $cliente['dni'] ?>" maxlength="8" required>
                                </div>
                                <div class="form-group">
                                    <label>Correo:</label>
                                    <input type="email" name="correo" value="<?= $cliente['correo_persona'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Teléfono:</label>
                                    <input type="text" name="telefono" value="<?= $cliente['telefono_persona'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Dirección:</label>
                                    <input type="text" name="direccion" value="<?= $cliente['direccion_persona'] ?>">
                                </div>
                            <?php elseif ($tipo === 'empresa'): ?>
                                <div class="form-group">
                                    <label>Razón Social:</label>
                                    <input type="text" name="razonsocial" value="<?= $cliente['razonsocial'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>RUC:</label>
                                    <input type="text" name="ruc" value="<?= $cliente['ruc'] ?>" maxlength="11" required>
                                </div>
                                <div class="form-group">
                                    <label>Correo:</label>
                                    <input type="email" name="correo" value="<?= $cliente['correo_empresa'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Teléfono:</label>
                                    <input type="text" name="telefono" value="<?= $cliente['telefono_empresa'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Dirección:</label>
                                    <input type="text" name="direccion" value="<?= $cliente['direccion_empresa'] ?>">
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="form-actions">
                            <a href="index.php?controller=cliente&action=index" class="btn">Cancelar</a>
                            <button type="submit"
                                class="btn btn-primary"><?= $isEdit ? 'Actualizar' : 'Registrar' ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>
</div>