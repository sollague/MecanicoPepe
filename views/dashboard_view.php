<?php
session_start(); // Inicia la sesión para poder acceder a datos del usuario

// ================= CONTROL DE ACCESO =================

// Verifica si el usuario ha iniciado sesión
<<<<<<< HEAD
if (!isset($_SESSION["usuario"])) {
=======
if (!isset($_SESSION['usuario'])) {

>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    // Si no hay sesión activa, lo redirige al login
    header("Location: login_view.php");
    exit(); // Detiene la ejecución del código
}
?>

<!DOCTYPE html>
<<<<<<< HEAD
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container py-5">

        <!-- HEADER -->
        <div class="card shadow border-0 mb-4">
            <div class="card-body text-center p-5">

                <h1 class="fw-bold text-primary">
                    🔧 MecanicoPepe
                </h1>

                <h5 class="mt-3">
                    Bienvenido,
                    <span class="text-dark fw-semibold">
                        <?= $_SESSION["usuario"] ?>
                    </span>
                </h5>

                <p class="text-muted mt-3 mb-0">
                    El mantenimiento preventivo permite evitar fallas futuras
                    y mantener el vehículo en óptimas condiciones.
                </p>

            </div>
        </div>

        <!-- MENU -->
        <div class="row g-4">

            <!-- FACTURA -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body text-center p-4">

                        <div class="display-4 mb-3">
                            🧾
                        </div>

                        <h4 class="fw-bold">
                            Facturación
                        </h4>

                        <p class="text-muted">
                            Genera facturas y registra servicios realizados.
                        </p>

                        <a href="servicios_view.php"
                            class="btn btn-primary w-100">

                            Generar Factura
                        </a>

                    </div>
                </div>
            </div>

            <!-- REPUESTOS -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body text-center p-4">

                        <div class="display-4 mb-3">
                            ⚙️
                        </div>

                        <h4 class="fw-bold">
                            Repuestos
                        </h4>

                        <p class="text-muted">
                            Consulta y administra el inventario disponible.
                        </p>

                        <a href="repuestos_view.php"
                            class="btn btn-success w-100">

                            Ver Inventario
                        </a>

                    </div>
                </div>
            </div>

            <!-- VEHICULOS -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body text-center p-4">

                        <div class="display-4 mb-3">
                            🚗
                        </div>

                        <h4 class="fw-bold">
                            Vehículos
                        </h4>

                        <p class="text-muted">
                            Registra y administra vehículos de clientes.
                        </p>

                        <a href="vehiculos_view.php"
                            class="btn btn-dark w-100">

                            Registrar Vehículos
                        </a>

                    </div>
                </div>
            </div>

        </div>

        <!-- BOTON LOGOUT -->
        <div class="text-center mt-5">

            <a href="../controllers/logout.php"
                class="btn btn-danger px-5">

                Cerrar sesión
            </a>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
=======
<html>

<head>
    <title>Dashboard</title>

    <!-- Conexión al archivo de estilos -->
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <div class="container">

        <div class="dashboard-header">
            <!-- Título del sistema -->
            <h2>MecanicoPepe</h2>

            <!-- Muestra el usuario que inició sesión -->
            <p>Bienvenido, <?= $_SESSION['usuario'] ?></p>

            <!-- Mensaje informativo del sistema -->
            <p>
                El mantenimiento preventivo permite evitar fallas futuras
                y mantener el vehículo en óptimas condiciones.
            </p>
        </div>

        <div class="dashboard-menu">
            <!-- Enlace para ir al módulo de servicios -->
            <a href="servicios_view.php">
                <span class="icon">🧾</span>
                Generar Factura
            </a>

            <a href="repuestos_view.php">
                <span class="icon">⚙️</span>
                Ver inventario de repuestos
            </a>

            <a href="vehiculos_view.php">
                <span class="icon">🚗</span>
                Registrar vehículos
            </a>

            <!-- Enlace para cerrar sesión -->
            <a href="../controllers/logout.php" class="btn-logout">
                Cerrar sesión
            </a>
        </div>
    </div>

</body>

</html>
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
