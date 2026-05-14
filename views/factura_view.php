<?php
session_start(); // Inicia sesión para acceder a los datos guardados del proceso

// ================= DATOS DE LA FACTURA =================

// Servicios seleccionados por el usuario (si no hay, array vacío)
$servicios = $_SESSION['servicios'] ?? [];

// Total de la factura (si no existe, 0)
$total = $_SESSION['total'] ?? 0;
$subtotal = $_SESSION['subtotal'] ?? 0;
$iva = $_SESSION['iva'] ?? 0;

// ================= DATOS DEL CLIENTE =================

$cliente = $_SESSION['cliente'] ?? '';
$cedula = $_SESSION['cedula'] ?? '';
$correo = $_SESSION['correo'] ?? '';
$telefono = $_SESSION['telefono'] ?? '';
$tipoMantenimiento =$_SESSION['tipo_mantenimiento'] ?? '';
$trabajos =$_SESSION['trabajos'] ?? '';
$vehiculo = $_SESSION['vehiculo'] ?? '';

// ================= DATOS GENERALES =================

$fecha = $_SESSION['fecha'] ?? '';
$factura_id = $_SESSION['factura_id'] ?? '';

// Mecánico seleccionado (array con nombre, experiencia y rating)
$mecanico = $_SESSION['mecanico'] ?? null;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Factura</title>

    <!-- Estilos del sistema -->
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <div class="container">

        <!-- Título con número de factura -->
        <h2>Factura #<?= $factura_id ?></h2>

        <!-- ================= DATOS DEL CLIENTE ================= -->

        <p><strong>Cliente:</strong> <?= $cliente ?></p>
        <p><strong>Cédula:</strong> <?= $cedula ?></p>
        <p><strong>Correo:</strong> <?= $correo ?></p>
        <p><strong>Teléfono:</strong> <?= $telefono ?></p>
        <p><strong>Vehículo:</strong> <?= $vehiculo ?></p>

        <!-- ================= DATOS DEL MECÁNICO ================= -->

        <p><strong>Mecánico:</strong> <?= $mecanico['nombre'] ?></p>
        <p>
            Exp: <?= $mecanico['experiencia'] ?> |
            ⭐ <?= $mecanico['rating'] ?>
        </p>

        <!-- Fecha del servicio -->
        <p><strong>Fecha:</strong> <?= $fecha ?></p>

        <p>
            <strong>Tipo:</strong>
            <?= $tipoMantenimiento ?>
        </p>

        <p>
            <strong>Trabajos realizados:</strong><br>
            <?= $trabajos ?>
        </p>

        <hr>

        <!-- ================= LISTA DE SERVICIOS ================= -->

        <table>
            <tr>
                <th>Servicio</th>
                <th>Precio</th>
            </tr>

            <!-- Recorre todos los servicios seleccionados -->
            <?php foreach ($servicios as $s): ?>
            <tr>
                <td><?= $s['nombre'] ?></td>
                <td>$<?= $s['precio'] ?></td>
            </tr>
            <?php endforeach; ?>

        </table>

        <!-- ================= TOTAL ================= -->

        <p><strong>Subtotal:</strong> $<?= number_format($subtotal, 2) ?></p>

        <p><strong>IVA 15%:</strong> $<?= number_format($iva, 2) ?></p>

        <p class="total">
            <strong>Total:</strong>
            $<?= number_format($total, 2) ?>
        </p>

        <!-- Botón para volver al dashboard -->
        <a href="dashboard_view.php">⬅ Volver</a>

    </div>
</body>

</html>