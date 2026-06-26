<?php
session_start();

// ================= DATOS DE LA FACTURA =================

$servicios = $_SESSION["servicios"] ?? [];
$total = $_SESSION["total"] ?? 0;
$subtotal = $_SESSION["subtotal"] ?? 0;
$iva = $_SESSION["iva"] ?? 0;

// ================= DATOS DEL CLIENTE =================

$cliente = $_SESSION["cliente"] ?? "";
$cedula = $_SESSION["cedula"] ?? "";
$correo = $_SESSION["correo"] ?? "";
$telefono = $_SESSION["telefono"] ?? "";
$tipoMantenimiento = $_SESSION["tipo_mantenimiento"] ?? "";
$trabajos = $_SESSION["trabajos"] ?? "";
$vehiculo = $_SESSION["vehiculo"] ?? "";

// ================= DATOS GENERALES =================

$fecha = $_SESSION["fecha"] ?? "";
$factura_id = $_SESSION["factura_id"] ?? "";
$mecanico = $_SESSION["mecanico"] ?? null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Factura</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body class="bg-light">

<div class="container py-5">

    <?php require_once __DIR__ . '/partials/flash_messages.php'; ?>

    <div class="card shadow border-0">

        <div class="card-body p-5">

            <!-- HEADER -->
            <div class="text-center mb-5">

                <h1 class="fw-bold text-primary">
                    🧾 Factura #<?= $factura_id ?>
                </h1>

                <p class="text-muted">
                    Taller Automotriz MecanicoPepe
                </p>

            </div>

            <!-- CLIENTE Y SERVICIO -->
            <div class="row mb-4">

                <div class="col-md-6">

                    <h4>👤 Cliente</h4>

                    <p><strong>Cliente:</strong> <?= $cliente ?></p>
                    <p><strong>Cédula:</strong> <?= $cedula ?></p>
                    <p><strong>Correo:</strong> <?= $correo ?></p>
                    <p><strong>Teléfono:</strong> <?= $telefono ?></p>
                    <p><strong>Vehículo:</strong> <?= $vehiculo ?></p>

                </div>

                <div class="col-md-6">

                    <h4>🔧 Servicio</h4>

                    <p><strong>Mecánico:</strong> <?= $mecanico["nombre"] ??
                        "" ?></p>
                    <p><strong>Experiencia:</strong> <?= $mecanico[
                        "experiencia"
                    ] ?? "" ?></p>
                    <p><strong>Rating:</strong> ⭐ <?= $mecanico["rating"] ??
                        "" ?></p>
                    <p><strong>Fecha:</strong> <?= $fecha ?></p>
                    <p><strong>Tipo:</strong> <?= $tipoMantenimiento ?></p>

                </div>

            </div>

            <!-- TRABAJOS -->
            <div class="mb-4">

                <h4>📝 Trabajos realizados</h4>

                <div class="border rounded p-3 bg-light">

                    <?= nl2br($trabajos) ?>

                </div>

            </div>

            <!-- SERVICIOS -->
            <h4 class="mb-3">⚙️ Servicios</h4>

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">
                        <tr>
                            <th>Servicio</th>
                            <th class="text-end">Precio</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($servicios as $s): ?>
                            <tr>
                                <td><?= $s["nombre"] ?></td>
                                <td class="text-end">$<?= number_format(
                                    $s["precio"],
                                    2,
                                ) ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- TOTALES -->
            <div class="row justify-content-end mt-4">

                <div class="col-md-4">

                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Subtotal</span>
                            <strong>$<?= number_format($subtotal, 2) ?></strong>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>IVA 15%</span>
                            <strong>$<?= number_format($iva, 2) ?></strong>
                        </li>

                        <li class="list-group-item active d-flex justify-content-between">
                            <span>TOTAL</span>
                            <strong>$<?= number_format($total, 2) ?></strong>
                        </li>

                    </ul>

                </div>

            </div>

            <!-- BOTONES -->
            <div class="mt-5 d-flex gap-3">

                <a href="dashboard_view.php" class="btn btn-secondary">
                    ⬅ Volver
                </a>

                <a href="../controllers/FacturaPdfController.php" class="btn btn-success">
                    📄 Descargar PDF
                </a>

                <button onclick="window.print()" class="btn btn-primary">
                    🖨 Imprimir
                </button>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
