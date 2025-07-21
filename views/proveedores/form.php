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
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <form action="index.php?controller=proveedor&action=<?= isset($proveedor) ? 'update' : 'store' ?>"
                        method="POST">
                        <?php if (isset($proveedor)): ?>
                            <input type="hidden" name="id_proveedor" value="<?= $proveedor['id_proveedor'] ?>">
                            <input type="hidden" name="id_empresa" value="<?= $empresa['id_empresa'] ?>">

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
                        <?php else: ?>
                            <div class="form-group">
                                <label for="proveedorId">Empresa *</label>
                                <select id="proveedorId" name="id_empresa" required>
                                    <option value="">—Seleccione un proveedor— </option>
                                    <?php foreach ($empresas as $empresa): ?>
                                        <option value="<?= $empresa['id_empresa'] ?>"
                                            <?= (isset($proveedor) && $proveedor['id_empresa'] == $empresa['id_empresa']) ? 'selected' : '' ?>>
                                            <?= $empresa['razonsocial'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <div class="form-actions">
                            <a href="index.php?controller=proveedor&action=index" class="btn">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <?= isset($proveedor) ? "Actualizar" : "Guardar" ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>