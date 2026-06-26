<!DOCTYPE html>
<html>
<head>
    <title>Login - MecanicoPepe</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="../controllers/UsuarioController.php">
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Ingresar</button>
    </form>
</body>
</html>