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

<main class="main">
    <h2>
        <span id="greeting"></span>
        <span class="user-name-text">
            <?= htmlspecialchars($_SESSION['usuario']['nombres']) ?>
        </span>
    </h2>
</main>

<script src="assets/js/greeting.js"></script>