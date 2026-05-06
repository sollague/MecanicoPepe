<?php
session_start(); // Inicia la sesión para poder acceder a datos del usuario

// ================= CONTROL DE ACCESO =================

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {

    // Si no hay sesión activa, lo redirige al login
    header("Location: login_view.php");
    exit(); // Detiene la ejecución del código
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>

    <!-- Conexión al archivo de estilos -->
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <div class="container">

        <!-- Título del sistema -->
        <h2>MecanicoPepe</h2>

        <!-- Muestra el usuario que inició sesión -->
        <p>Bienvenido, <?= $_SESSION['usuario'] ?></p>

        <!-- Mensaje informativo del sistema -->
        <p>
            El mantenimiento preventivo permite evitar fallas futuras
            y mantener el vehículo en óptimas condiciones.
        </p>

        <!-- Enlace para ir al módulo de servicios -->
        <a href="servicios_view.php">Solicitar servicio</a>
        <br><br>

        <!-- Enlace para cerrar sesión -->
        <a href="../controllers/logout.php">Cerrar sesión</a>

    </div>

</body>

</html>