<nav class="navbar">
    <div class="navbar-brands">
        <a href="index.php?controller=panel&action=index" class="navbar-brand">
            <div class="icon xl">
                <img src="./assets/images/logo.svg" alt="">
            </div>
            <span class="navbar-title">Arimana Bazar</span>
        </a>
    </div>
    <ul class="navbar-links">
        <li>
            <a href="index.php?controller=panel&action=index" class="navbar-item">
                <div class="icon">
                    <img src="./assets/icons/chart.svg" alt="">
                </div>
                Panel
            </a>
        </li>
        <li>
            <a href="index.php?controller=usuario&action=index" class="navbar-item">
                <div class="icon">
                    <img src="./assets/icons/users.svg" alt="">
                </div>
                Usuarios
            </a>
        </li>
        <li>
            <a href="index.php?controller=pedido&action=index" class="navbar-item">
                <div class="icon">
                    <img src="./assets/icons/truck.svg" alt="">
                </div>
                Pedidos
            </a>
        </li>
        <li>
            <a href="index.php?controller=producto&action=index" class="navbar-item">
                <div class="icon">
                    <img src="./assets/icons/package.svg" alt="">
                </div>
                Inventario
            </a>
        </li>
        <li>
            <a href="index.php?controller=venta&action=index" class="navbar-item">
                <div class="icon">
                    <img src="./assets/icons/shop-cart.svg" alt="">
                </div>
                Ventas
            </a>
        </li>
    </ul>

    <div class="navbar-settings">
        <!-- <a href="index.php?controller=usuario&action=perfil" class="navbar-item">
            <div class="icon">
                <img src="./assets/icons/settings.svg" alt="">
            </div>
        </a>

        <div class="separator"></div> -->

        <div class="navbar-item">
            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="user-info">
                    <input type="checkbox" id="userMenuToggle" class="user-name" />
                    <label for="userMenuToggle">
                        <div class="icon">
                            <img src="./assets/icons/circle-user.svg" alt="">
                        </div>
                        <span class="user-name-text">
                            <?= htmlspecialchars($_SESSION['usuario']['nombres']) ?>
                        </span>
                    </label>

                    <div class="user-details">
                        <div class="details-group user-email">
                            <span>Correo</span>
                            <?= htmlspecialchars($_SESSION['usuario']['correo']) ?>
                        </div>
                        <div class="details-group user-rol">
                            <span>Rol</span>
                            <?= htmlspecialchars($_SESSION['usuario']['rol']) ?>
                        </div>
                        <hr>
                        <button class="navbar-item" id="logoutBtn">
                            Cerrar sesión
                            <div class="icon">
                                <i style="font-size: 18px" class="fa-solid fa-arrow-right-from-bracket"></i>
                            </div>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>