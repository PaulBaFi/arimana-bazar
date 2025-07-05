<aside class="sidebar">
    <ul class="sidebar-menu">
        <li>
            <input type="checkbox" id="productos" class="menu-item-check">
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
                    <a href="index.php?controller=producto&action=create" class="menu-item-link">Agregar productos</a>
                </li>
                <li>
                    <a href="" class="menu-item-link">Buscar productos</a>
                </li>
            </ul>
        </li>

        <li>
            <input type="checkbox" id="categorias" class="menu-item-check" checked>
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
                    <a href="index.php?controller=categoria&action=create" class="menu-item-link active">Crear
                        categoria</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Gestión de Categorías</h1>
            <p>Administrar las categorías de productos</p>
        </header>

        <div class="main-content">
            <div class="form-section" id="formSection">
                <div class="form-content">
                    <form action="index.php?controller=categoria&action=<?= isset($categoria) ? 'update' : 'store' ?>"
                        method="POST">
                        <?php if (isset($categoria)): ?>
                            <input type="hidden" name="id_categoria" value="<?= $categoria['id_categoria'] ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="categoria">Categoría:</label>
                            <input type="text" class="form-control" name="nom_cat" id="categoria" maxlength="100"
                                required placeholder="Ingrese el nombre de la categoría"
                                value="<?= $categoria['nom_cat'] ?? '' ?>" />
                        </div>

                        <div class="form-actions">
                            <a href="index.php?controller=categoria&action=index" class="btn">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <?= isset($categoria) ? "Actualizar" : "Guardar" ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>