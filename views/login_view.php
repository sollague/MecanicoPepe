<!DOCTYPE html>
<<<<<<< HEAD
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MecanicoPepe</title>

    <link rel="stylesheet" href="../styles/style.css">
    
</head>
<body>
    <!-- ============================================================ -->
    <!-- CONTENEDOR PRINCIPAL DE LOGIN -->
    <!-- ============================================================ -->
    <div class="login-container">
        
        <!-- ========================================================== -->
        <!-- TARJETA DE LOGIN -->
        <!-- ========================================================== -->
        <div class="login-box">
            
            <!-- ===================================================== -->
            <!-- BRANDING Y LOGO -->
            <!-- ===================================================== -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="color: var(--color-primary); margin: 0; font-size: 2.5rem; margin-bottom: 0.5rem;">
                    MecanicoPepe
                </h1>
                <p style="color: var(--color-text-secondary); margin: 0;">
                    Sistema de Gestión de Taller Automotriz
                </p>
            </div>
            
            <!-- ===================================================== -->
            <!-- MOSTRAR ERRORES SI LOS HAY -->
            <!-- ===================================================== -->
            <?php
                /**
                 * Iniciar sesión para acceder a $_SESSION
                 */
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                /**
                 * Si hay mensaje de error en SESSION
                 */
                if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($_SESSION['error']); ?>
                </div>
                <?php
                    unset($_SESSION['error']);
                endif;
            ?>
            
            <!-- ===================================================== -->
            <!-- FORMULARIO DE LOGIN -->
            <!-- ===================================================== -->
            <form method="POST" action="../controllers/UsuarioController.php">
                
                <!-- =============================================== -->
                <!-- CAMPO: USUARIO -->
                <!-- =============================================== -->
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input 
                        type="text" 
                        id="usuario" 
                        name="usuario" 
                        placeholder="Ingrese su usuario"
                        autocomplete="username"
                        required
                        minlength="2"
                        maxlength="50"
                        autofocus
                    >
                </div>
                
                <!-- =============================================== -->
                <!-- CAMPO: CONTRASEÑA -->
                <!-- =============================================== -->
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Ingrese su contraseña"
                        autocomplete="current-password"
                        required
                        minlength="2"
                        maxlength="100"
                    >
                </div>
                
                <!-- =============================================== -->
                <!-- BOTÓN DE ENVÍO -->
                <!-- =============================================== -->
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    ✓ Iniciar Sesión
                </button>
                
            </form>
            
            <!-- ===================================================== -->
            <!-- INFORMACIÓN DE PRUEBA -->
            <!-- ===================================================== -->
            <hr style="margin: 1.5rem 0; border: none; height: 1px; background-color: var(--color-border);">
            
            <p style="text-align: center; margin: 0; color: var(--color-text-secondary); font-size: 0.875rem;">
                <strong>Credenciales de prueba:</strong><br>
                Usuario: <code style="background: var(--color-bg-secondary); padding: 0.25rem 0.5rem; border-radius: 4px;">admin</code><br>
                Contraseña: <code style="background: var(--color-bg-secondary); padding: 0.25rem 0.5rem; border-radius: 4px;">1234</code>
            </p>
            
        </div>
        
    </div>
    
    <!-- ============================================================ -->
    <!-- VALIDACIONES EN CLIENTE (JAVASCRIPT) -->
    <!-- ============================================================ -->
    <script>
        /**
         * Mejoras de UX en el login
         */
        document.addEventListener('DOMContentLoaded', function() {
            
            const formulario = document.querySelector('form');
            const campoUsuario = document.querySelector('#usuario');
            const campoPassword = document.querySelector('#password');
            
            /**
             * Seleccionar texto del usuario cuando hace focus
             */
            campoUsuario.addEventListener('focus', function() {
                this.select();
            });
            
            /**
             * Validación en el submit
             */
            formulario.addEventListener('submit', function(event) {
                
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
    
=======
<html>

<head>

    <title>Login</title>

    <link rel="stylesheet"
          href="../styles/style.css">

</head>

<body>

<div class="container">

    <h2>MecanicoPepe</h2>

    <form method="POST"
          action="../controllers/UsuarioController.php">

        <label>Usuario:</label>

        <input type="text"
               name="usuario"
               required>

        <label>Contraseña:</label>

        <input type="password"
               name="password"
               required>

        <button type="submit">
            Ingresar
        </button>

    </form>

</div>

>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
</body>
</html>