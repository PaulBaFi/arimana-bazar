<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Arimana Bazar</title>
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="./assets/css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="float-logo">
        <img src="./assets/images/logo.svg" alt="">
    </div>

    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <img src="./assets/images/img-5.png" alt="">
                <img src="./assets/images/img-9.png" alt="">
                <img src="./assets/images/img-12.png" alt="">
            </div>
            <h1>Iniciar Sesión</h1>
            <div class="aviso-info">
                <p><strong>Atención:</strong> Esta aplicación es de acceso exclusivo para el personal de trabajo en
                    Arimana Bazar.
                </p>
            </div>
            <form action="auth.php" method="POST">
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" name="correo" required />
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="clave" required />
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                <div class="volver-landing">
                    <a href="index.php?controller=landing&action=index">Volver a la página de inicio</a>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'no_encontrado'): ?>
    <script>
    Swal.fire({
        title: 'Error',
        text: 'El correo no está registrado.',
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });

    Swal.fire({
        title: '¡Bienvenido!',
        text: `
                <?php if (isset($_SESSION['usuario'])): ?>
                    Bienvenid@ <?= htmlspecialchars($_SESSION['usuario']['nombres']) ?>
                <?php endif ?>
                `,
        icon: 'success',
        confirmButtonText: 'Continuar',
        timer: 2500,
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then(() => {
        window.location.href = 'index.php?controller=panel&action=index';
    });
    </script>
    <?php endif;  ?>

</body>

</html>