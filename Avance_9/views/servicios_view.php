<?php

session_start();
require_once "../models/MecanicoPepe.php";

$model = new MecanicoPepe();

$oldInput = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);

$selectedServicios = $oldInput['servicios'] ?? [];
$mecanicoSeleccionadoId = $oldInput['mecanico'] ?? '';
$tipoMantenimientoSeleccionado = $oldInput['tipo_mantenimiento'] ?? '';

/*
|--------------------------------------------------------------------------
| OBTENER SERVICIOS
|--------------------------------------------------------------------------
*/
$servicios = $model->executeQuery("SELECT * FROM servicios");

/*
|--------------------------------------------------------------------------
| OBTENER MECÁNICOS
|--------------------------------------------------------------------------
*/
$mecanicos = $model->executeQuery("SELECT * FROM mecanicos");
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Servicios</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">

</head>

<body class="bg-light">

<div class="container py-5">

    <?php require_once __DIR__ . '/partials/flash_messages.php'; ?>

    <!-- TITULO -->
    <div class="text-center mb-5">

        <h1 class="fw-bold text-primary">
            🧾 Solicitar Servicio
        </h1>

        <p class="text-muted">
            Gestión de servicios automotrices y facturación
        </p>

    </div>

    <form method="POST" action="../controllers/ServicioController.php">

        <!-- DATOS CLIENTE -->
        <div class="card shadow border-0 mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">👤 Datos del Cliente</h3>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="cliente" class="form-control" required value="<?= htmlspecialchars($oldInput['cliente'] ?? '') ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cédula</label>
                        <input type="text" name="cedula" class="form-control" required value="<?= htmlspecialchars($oldInput['cedula'] ?? '') ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" required value="<?= htmlspecialchars($oldInput['correo'] ?? '') ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required value="<?= htmlspecialchars($oldInput['telefono'] ?? '') ?>">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Vehículo</label>
                        <input type="text" name="vehiculo" class="form-control" required value="<?= htmlspecialchars($oldInput['vehiculo'] ?? '') ?>">
                    </div>

                </div>

            </div>
        </div>

        <!-- MECANICOS -->
        <div class="card shadow border-0 mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">🔧 Selecciona un Mecánico</h3>

                <div class="row">

                    <?php foreach ($mecanicos as $m): ?>

                        <div class="col-md-6 mb-3">

                            <label class="card h-100 border shadow-sm">

                                <div class="card-body">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                               type="radio"
                                               name="mecanico"
                                               value="<?= $m["id"] ?>"
                                               required
                                               <?= ((string) $mecanicoSeleccionadoId === (string) $m["id"]) ? 'checked' : '' ?> >

                                        <span class="fw-bold fs-5">
                                            <?= $m["nombre"] ?>
                                        </span>

                                    </div>

                                    <hr>

                                    <p><strong>Experiencia:</strong> <?= $m[
                                        "experiencia"
                                    ] ?></p>
                                    <p>⭐ <?= $m["rating"] ?></p>

                                </div>

                            </label>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>
        </div>

        <!-- SERVICIOS -->
        <div class="card shadow border-0 mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">⚙️ Servicios Disponibles</h3>

                <div class="row">

                    <?php foreach ($servicios as $s): ?>

                        <div class="col-md-6 mb-3">

                            <label class="card h-100 border shadow-sm">

                                <div class="card-body">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="servicios[]"
                                               value="<?= $s["id"] ?>"
                                               <?= in_array((string)$s["id"], array_map('strval', $selectedServicios), true) ? 'checked' : '' ?>>

                                        <span class="fw-bold">
                                            <?= $s["nombre"] ?>
                                        </span>

                                    </div>

                                    <hr>

                                    <p class="text-success fw-bold">
                                        $<?= $s["precio"] ?>
                                    </p>

                                    <small class="text-muted">
                                        <?= $s["descripcion"] ?>
                                    </small>

                                </div>

                            </label>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>
        </div>

        <!-- TIPO MANTENIMIENTO -->
        <div class="card shadow border-0 mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">🛠 Tipo de Mantenimiento</h3>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="tipo_mantenimiento" value="Preventivo" required <?= $tipoMantenimientoSeleccionado === 'Preventivo' ? 'checked' : '' ?>>
                    <label class="form-check-label">Preventivo</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_mantenimiento" value="Correctivo" required <?= $tipoMantenimientoSeleccionado === 'Correctivo' ? 'checked' : '' ?>>
                    <label class="form-check-label">Correctivo</label>
                </div>

            </div>
        </div>

        <!-- TRABAJOS -->
        <div class="card shadow border-0 mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">📝 Trabajos Realizados</h3>

                <textarea name="trabajos" class="form-control" rows="5" required><?= htmlspecialchars($oldInput['trabajos'] ?? '') ?></textarea>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex gap-3">

            <button type="submit" class="btn btn-primary btn-lg">
                Generar Factura
            </button>

            <a href="dashboard_view.php" class="btn btn-secondary btn-lg">
                ⬅ Volver
            </a>

        </div>

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
