<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - MecanicoPepe</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-md-6 col-lg-4">

                <div class="card shadow border-0">

                    <div class="card-body p-5">

                        <!-- LOGO / TITULO -->
                        <div class="text-center mb-4">

                            <h1 class="fw-bold text-primary">
                                🔧 MecanicoPepe
                            </h1>

                            <p class="text-muted mb-0">
                                Sistema de Gestión de Taller Automotriz
                            </p>

                        </div>

                        <!-- MENSAJES DE ERROR -->
                        <?php
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }

                        if (isset($_SESSION["error"])): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($_SESSION["error"]) ?>
                            </div>
                        <?php unset($_SESSION["error"]);endif;
                        ?>

                        <!-- FORMULARIO -->
                        <form method="POST" action="../controllers/UsuarioController.php">

                            <!-- USUARIO -->
                            <div class="mb-3">

                                <label for="usuario" class="form-label">Usuario</label>

                                <input type="text"
                                       id="usuario"
                                       name="usuario"
                                       class="form-control"
                                       placeholder="Ingrese su usuario"
                                       autocomplete="username"
                                       required
                                       minlength="2"
                                       maxlength="50"
                                       autofocus>

                            </div>

                            <!-- PASSWORD -->
                            <div class="mb-4">

                                <label for="password" class="form-label">Contraseña</label>

                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Ingrese su contraseña"
                                       autocomplete="current-password"
                                       required
                                       minlength="2"
                                       maxlength="100">

                            </div>

                            <!-- BOTON -->
                            <button type="submit" class="btn btn-primary w-100">
                                Iniciar Sesión
                            </button>

                        </form>

                        <!-- CREDENCIALES DE PRUEBA -->
                        <div class="mt-4">

                            <div class="alert alert-secondary mb-0">

                                <h6 class="fw-bold">Credenciales de prueba</h6>

                                <p class="mb-1">
                                    Usuario: <code>admin</code>
                                </p>

                                <p class="mb-0">
                                    Contraseña: <code>1234</code>
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- VALIDACIONES -->
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const formulario = document.querySelector('form');
            const campoUsuario = document.querySelector('#usuario');
            const campoPassword = document.querySelector('#password');

            campoUsuario.addEventListener('focus', function () {
                this.select();
            });

            formulario.addEventListener('submit', function (event) {

                const usuario = campoUsuario.value.trim();
                const password = campoPassword.value.trim();

                if (!usuario || !password) {
                    event.preventDefault();
                    alert('Por favor ingrese usuario y contraseña');
                    return false;
                }

                return true;
            });

        });

    </script>

</body>
</html>
