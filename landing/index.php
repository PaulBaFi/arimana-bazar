<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arimana Bazar</title>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./assets/css/landing.css">
</head>

<body>
    <nav class="landing-navbar">
        <div class="navbar-header">
            <img src="./assets/images/logo.svg" alt="">
        </div>
        <label for="toggleMenu" class="display-menu">
            <div class="display-btn" onclick="openNav()">
                <div class="icon">
                    <?php include "./assets/icons/menu.php" ?>
                </div>
                Menu
            </div>
            <input type="checkbox" name="toggleMenu" id="toggleMenu">
        </label>
        <div class="navbar-links" id="myNav">
            <div class="icon" onclick="closeNav()">
                <?php include "./assets/icons/x.php" ?>
            </div>
            <a href="#productos">Productos</a>
            <a href="#resenas">Reseñas</a>
            <a href="#contacto">Contacto</a>
            <a href="#nosotros">Nosotros</a>
        </div>
        <div class="navbar-settings">
            <a href="login.php">Ingresar</a>
        </div>
    </nav>

    <header class="landing-hero">
        <div class="landing-hero__text">
            <h1>Arimana Bazar</h1>
            <p>Tu aliado para encontrar productos <span id="element"></span> en un solo
                lugar. </p>
            <a href="#productos" class="link-item">Catálogo de productos</a>
        </div>

        <div class="landing-hero__content container">
            <img style="--scale: 2.5;" src="./assets/images/img-3.png" alt="Imagen 3" />
            <img style="--scale: 2;" src="./assets/images/img-4.png" alt="Imagen 4" />
            <img style="--scale: 1;" src="./assets/images/img-1.png" alt="Imagen 1" />
            <img style="--scale: 2;" src="./assets/images/img-8.png" alt="Imagen 8" />
            <img style="--scale: 2.5;" src="./assets/images/img-10.png" alt="Imagen 10" />
        </div>
    </header>

    <section class="landing-info grand-section">
        <h2>¿Por qué comprar en <strong>Arimana Bazar</strong>?</h2>
        <div class="landing-info-grid container">
            <div class="landing-info-card">
                <div class="icon">
                    <?php include "./assets/icons/fast.php"; ?>
                </div>
                <p> <strong>Envíos rápidos y seguros</strong> <br />
                    Entrega ágil y confiable</p>
            </div>
            <div class="landing-info-card">
                <div class="icon">
                    <?php include "./assets/icons/check.php"; ?>
                </div>
                <p> <strong>Productos seleccionados</strong> <br>
                    Solo lo mejor, útil y de calidad.</p>
            </div>
            <div class="landing-info-card">
                <div class="icon">
                    <?php include "./assets/icons/message.php"; ?>
                </div>
                <p> <strong>Atención personalizada</strong> <br>
                    Te ayudamos cuando lo necesites</p>
            </div>
            <div class="landing-info-card">
                <div class="icon">
                    <?php include "./assets/icons/piggy.php"; ?>
                </div>
                <p> <strong>Métodos de pago flexibles</strong> <br>
                    Paga como prefieras, sin complicaciones</p>
            </div>
        </div>
    </section>

    <main>
        <section id="productos" class="grand-section">
            <h2>Todo lo que buscas en <strong>Productos</strong></h2>
            <div class="productos-galeria container">
                <?php include './lib/productos.php'; ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto-card">
                        <img src="<?= htmlspecialchars($producto['imagen']) ?>"
                            alt="<?= htmlspecialchars($producto['nombre']) ?>" />
                        <div class="producto-card__info">
                            <p><?= htmlspecialchars($producto['nombre']) ?></p>
                            <b><?= htmlspecialchars($producto['precio']) ?></b>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="resenas" class="grand-section">
            <h2>Valoraciones hechas desde la <strong>experiencia</strong></h2>
            <div class="carrousel-wrapper-horizontal container">

                <?php
                include './lib/reviews.php';

                function renderStars($rating, $max = 5)
                {
                    for ($i = 0; $i < $max; $i++) {
                        if ($i < $rating) { ?>
                            <div class="icon">
                                <?php include "./assets/icons/star.php"; ?>
                            </div>
                        <?php } else { ?>
                            <div class="icon">
                                <?php include "./assets/icons/star-empty.php"; ?>
                            </div>
                <?php }
                    }
                }
                ?>

                <div class="horizontal-carrousel">
                    <?php foreach ($reviews1 as $index => $review): ?>
                        <div class="itemLeft item<?= $index + 1 ?>" style="--delay: <?= 8 - $index ?>;">
                            <p class="review-user"><?= htmlspecialchars($review["user"]) ?></p>
                            <div class="review-stars">
                                <?php renderStars($review["rating"]); ?>
                            </div>
                            <p class="review-text"><?= htmlspecialchars($review["text"]) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="horizontal-carrousel">
                    <?php foreach ($reviews2 as $index => $review): ?>
                        <div class="itemRight item<?= $index + 1 ?>" style="--delay: <?= 8 - $index ?>;">
                            <p class="review-user"><?= htmlspecialchars($review["user"]) ?></p>
                            <div class="review-stars">
                                <?php renderStars($review["rating"]); ?>
                            </div>
                            <p class="review-text"><?= htmlspecialchars($review["text"]) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>
    </main>

    <section id="contacto" class="landing-contact grand-section">
        <h2>¿Necesitas más información? <strong>Contáctanos</strong></h2>
        <div class="contact-container container">
            <div class="social-media-v">
                <a href="https://web.facebook.com/arimanabazarica/" target="_blank">
                    <span class="icon">
                        <?php include "./assets/icons/facebook.php"; ?>
                    </span>
                </a>
                <a href="https://www.instagram.com/arimanabazarica/" target="_blank">
                    <span class="icon">
                        <?php include "./assets/icons/instagram.php"; ?>
                    </span>
                </a>
                <a href="https://wa.me/+51944920774" target="_blank">
                    <span class="icon">
                        <?php include "./assets/icons/phone.php"; ?>
                    </span>
                </a>
                <a href="mailto:bazararimana@gmail.com" target="_blank">
                    <span class="icon">
                        <?php include "./assets/icons/mail.php"; ?>
                    </span>
                </a>
            </div>

            <div class="form-container">
                <form action="mail.php" method="POST">
                    <input type="email" name="correo" placeholder="Ingrese su correo" required>
                    <textarea name="mensaje" placeholder="Ingrese su mensaje" required></textarea>
                    <button type="submit">Enviar</button>
                </form>
            </div>

            <div class="map-container">
                <a href="https://www.google.com/maps/dir/-14.0517544,-75.7313228/-14.0445861,-75.7431735/@-14.0470474,-75.7488854,15z/data=!3m1!4b1!4m4!4m3!1m1!4e1!1m0?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D"
                    target="_blank">
                    <img src="./assets/images/map.png" alt="">
                </a>
            </div>
        </div>
    </section>

    <section id="nosotros" class="landing-nosotros grand-section">
        <h2>Todo comienza con un gran <strong>objetivo</strong></h2>
        <div class="nosotros-container container">
            <?php
            include "./lib/nostoros.php";

            foreach ($nosotrosCards as $card): ?>
                <div class="nosotros-card">
                    <div class="icon">
                        <?php require $card['icon']; ?>
                    </div>
                    <b class="nosotros-title"><?= htmlspecialchars($card['title']) ?></b>
                    <p class="nosotros-text"><?= htmlspecialchars($card['text']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="landing-footer">
        <div class="footer-content">
            <div class="autores-content container">
                <div class="autores-info1">
                    <div class="autores-nombre">
                        <p>Barahona Figueroa Paul Alexis</p>
                        <a href="mailto:paul.barahona@upsjb.edu.pe">paul.barahona@upsjb.edu.pe ↗</a>
                    </div>
                    <div class="autores-nombre">
                        <p>Muñoz Castro Olenka del Rosario</p>
                        <a href="mailto:olenka.munoz@upsjb.edu.pe">olenka.munoz@upsjb.edu.pe ↗</a>
                    </div>
                    <div class="autores-nombre">
                        <p>Torres Sacha Isaura Isabek</p>
                        <a href="mailto:isaura.torres@upsjb.edu.pe">isaura.torres@upsjb.edu.pe ↗</a>
                    </div>
                </div>

                <div class="autores-info2">
                    <div class="autores-escuela">
                        <span>Docente</span>
                        <p>Mg. Melendez Ramos Julio Genaro</p>
                    </div>
                    <div class="autores-escuela">
                        <span>Facultad</span>
                        <p>Facultad de Ingenierías</p>
                    </div>
                    <div class="autores-escuela">
                        <span>Carrera</span>
                        <p>Ingeniería en Sistema</p>
                    </div>
                    <div class="autores-escuela">
                        <span>Ciclo</span>
                        <p>V Ciclo \ 2025 - 01</p>
                    </div>
                </div>

                <div class="autores-info3">
                    <div class="autores-social">
                        <h4>Encuentranos en</h4>
                    </div>
                    <div class="social-media-h">
                        <a href="https://web.facebook.com/arimanabazarica/" target="_blank">
                            <span class="icon">
                                <?php include "./assets/icons/facebook.php"; ?>
                            </span>
                        </a>
                        <a href="https://www.instagram.com/arimanabazarica/" target="_blank">
                            <span class="icon">
                                <?php include "./assets/icons/instagram.php"; ?>
                            </span>
                        </a>
                        <a href="https://wa.me/+51944920774" target="_blank">
                            <span class="icon">
                                <?php include "./assets/icons/phone.php"; ?>
                            </span>
                        </a>
                        <a href="mailto:bazararimana@gmail.com" target="_blank">
                            <span class="icon">
                                <?php include "./assets/icons/mail.php"; ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-info container">
                <a href=""><img src="./assets/images/logo.svg" alt="">Arimana Bazar</a>
                <span>•</span>
                <a href="https://www.upsjb.edu.pe/" target="_blank"><img src="./assets/images/logo-upsjb.webp"
                        alt=""></a>
            </div>

            <div class="footer-copy container">
                <p class="copy">&copy; Copyright 2025 | Todos los derechos reservados</p>
            </div>
        </div>
    </footer>

    <!-- Dependencia Typed Script -->
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var typed = new Typed('#element', {
            strings: ['de calidad', 'confiables', 'accesibles'],
            typeSpeed: 70,
            backSpeed: 50,
            loop: true,
        });

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'enviado'): ?>
            Swal.fire({
                title: 'Mensaje enviado',
                text: 'Tu mensaje ha sido enviado. Gracias.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        <?php endif; ?>

        function openNav() {
            document.getElementById("myNav").classList.toggle("active");
        }

        function closeNav() {
            document.getElementById("myNav").classList.toggle("active");
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Selecciona todos los enlaces dentro del menú
            const navLinks = document.querySelectorAll("#myNav a");

            navLinks.forEach(function(link) {
                link.addEventListener("click", function() {
                    closeNav();
                });
            });
        });
    </script>
</body>

</html>