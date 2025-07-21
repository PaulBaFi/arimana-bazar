<aside class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <input type="checkbox" id="productos" class="menu-item-check" checked>
            <label class="sidebar-title" for="productos">
                <span>Productos</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>
            <ul class="submenu">
                <li>
                    <a href="index.php?controller=producto&action=index" class="menu-item-link">Listar
                        productos</a>
                </li>
                <li>
                    <a href="index.php?controller=producto&action=create" class="menu-item-link active">Agregar
                        productos</a>
                </li>
                <li>
                    <a href="" class="menu-item-link">Buscar productos</a>
                </li>
            </ul>
        </li>

        <li>
            <input type="checkbox" id="categorias" class="menu-item-check">
            <label class="sidebar-title" for="categorias">
                <span>Categorias</span>
                <div class="icon">
                    <span class="item item-v" aria-hidden="true"></span>
                    <span class="item item-h" aria-hidden="true"></span>
                </div>
            </label>

            <ul class="submenu">
                <li>
                    <a href="index.php?controller=categoria&action=index" class="menu-item-link">Listar categorias</a>
                </li>
                <li>
                    <a href="index.php?controller=categoria&action=create" class="menu-item-link">Crear
                        categoria</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Gestión de productos</h1>
            <p>Administra la información de los productos registradas.</p>
        </header>

        <div class="main-content">
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <form action="index.php?controller=producto&action=<?= isset($producto) ? 'update' : 'store' ?>"
                        method="POST">
                        <?php if (isset($producto)): ?>
                            <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="producto">Categoría:</label>
                            <select name="id_categoria" required>
                                <option value="">—Seleccione una categoría—</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['id_categoria'] ?>"
                                        <?= (isset($producto) && $producto['id_categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['nom_cat']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="producto">Producto:</label>
                            <input type="text" class="form-control" name="nom_prod" id="producto" maxlength="50"
                                required placeholder="Ingrese el nombre del producto"
                                value="<?= $producto['nom_prod'] ?? '' ?>" />
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" class="form-control" name="descripcion_prod" id="descripcion"
                                maxlength="100" placeholder="Ingrese una descripción del producto"
                                value="<?= $producto['descripcion_prod'] ?? '' ?>" />
                        </div>

                        <div class="form-group">
                            <label for="existencia">Existencia:</label>
                            <input type="number" class="form-control" name="existencia" id="existencia" min="1" step="1"
                                maxlength="11" required value="<?= $producto['existencia'] ?? '' ?>" />
                        </div>

                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="number" class="form-control" name="precio" id="precio" step="0.01"
                                maxlength="11" required value="<?= $producto['precio'] ?? '' ?>" />
                        </div>

                        <div class="form-actions">
                            <a href="index.php?controller=producto&action=index" class="btn">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <?= isset($producto) ? "Actualizar" : "Guardar" ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>