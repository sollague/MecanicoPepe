<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    <!-- Conexión al archivo de estilos del sistema -->
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <div class="container">

        <!-- Título del sistema -->
        <h2>MecanicoPepe</h2>

        <!-- ================= FORMULARIO DE LOGIN ================= -->

        <!--
            method="POST" → envía datos de forma segura
            action → envía los datos al controlador que valida el login
        -->
        <form method="POST" action="../controllers/UsuarioController.php">

            <!-- Campo usuario -->
            <label>Usuario:</label>
            <input type="text" name="usuario" required>

            <!-- Campo contraseña -->
            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <!-- Botón de envío -->
            <button type="submit">Ingresar</button>

        </form>

    </div>

</body>

</html>