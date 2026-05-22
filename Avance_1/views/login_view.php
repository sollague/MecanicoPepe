<!DOCTYPE html>
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

</body>
</html>