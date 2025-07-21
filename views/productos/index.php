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
                    <a href="index.php?controller=producto&action=index" class="menu-item-link active">Listar
                        productos</a>
                </li>
                <li>
                    <a href="index.php?controller=producto&action=create" class="menu-item-link">Agregar
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
                    <a href="index.php?controller=categoria&action=index" class="menu-item-link ">Listar categorias</a>
                </li>
                <li>
                    <a href="index.php?controller=categoria&action=create" class="menu-item-link">Crear categoria</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<div class="main-container">
    <main class="main">
        <header class="header">
            <h1>Gestión de productos</h1>
            <p>Administra la información de los productos registradas</p>
        </header>

        <div class="main-content">
            <div class="toolbar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Buscar productos por nombre ...">
                </div>

                <a href="index.php?controller=producto&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Registrar producto
                </a>
            </div>

            <div class="table-grid">
                <div class="table-container">
                    <table class="base-table " id="productosTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Categoría</th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Existencia</th>
                                <th>Precio</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($productos)): ?>
                                <tr>
                                    <td colspan="8" class="no-registros">No hay productos registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($productos as $producto): ?>
                                    <tr class="<?= 'estado-' . $producto['estado'] ?>">
                                        <td><?= $producto['id_producto'] ?></td>
                                        <td><?= $producto['nom_cat']  ?></td>
                                        <td><?= $producto['nom_prod']  ?></td>
                                        <td><?= $producto['descripcion_prod']  ?></td>
                                        <td>
                                            <span class="span_cell total_unidades">
                                                <?= $producto['existencia'] . ' unidades' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="span_cell total_precio">
                                                <?= 'S/. ' . $producto['precio'] ?>
                                            </span>
                                        </td>
                                        <td><?= $producto['fecha_registro'] ?></td>
                                        <td>
                                            <?php if ($producto['estado'] == 1): ?>
                                                <div class="actions">
                                                    <a href="index.php?controller=producto&action=edit&id=<?= $producto['id_producto'] ?>"
                                                        class="btn btn-sm btn-edit">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </a>
                                                    <a href="index.php?controller=producto&action=delete&id=<?= $producto['id_producto'] ?>"
                                                        class="btn btn-sm btn-delete btn-delete-producto"
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
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (isset($_GET['error'])): ?>
            <?php if ($_GET['error'] === 'campos_vacios'): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos vacíos',
                    text: 'Todos los campos son obligatorios.',
                    confirmButtonColor: '#3085d6'
                });
            <?php elseif ($_GET['error'] === 'datos_invalidos'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Datos inválidos',
                    text: 'Los campos "Existencia" y "Precio" deben ser numéricos.',
                    confirmButtonColor: '#d33'
                });
            <?php endif; ?>
        <?php elseif (isset($_GET['msg'])): ?>
            <?php
            $msg = $_GET['msg'];
            $text = $msg === 'creado' ? 'Producto registrado correctamente.'
                : ($msg === 'actualizado' ? 'Producto actualizado correctamente.'
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
                window.location.href = "index.php?controller=producto&action=index";
            });
        <?php endif; ?>
    });

    document.querySelectorAll(".btn-delete-producto").forEach(button => {
        button.addEventListener("click", async function(e) {
            e.preventDefault();

            const url = this.getAttribute("href");

            const result = await Swal.fire({
                title: "¿Desea eliminar a el producto?",
                text: "El producto cambiará su estado a inactivo.",
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