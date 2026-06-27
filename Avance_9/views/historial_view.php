<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login_view.php");
    exit();
}

require_once __DIR__ . '/../models/MecanicoPepe.php';

$model = new MecanicoPepe();

$cliente = trim($_GET['cliente'] ?? '');
$vehiculo = trim($_GET['vehiculo'] ?? '');
$mecanico = trim($_GET['mecanico'] ?? '');
$dateFrom = trim($_GET['date_from'] ?? '');
$dateTo = trim($_GET['date_to'] ?? '');

$conditions = [];
$params = [];

if ($cliente !== '') {
    $conditions[] = 'f.cliente LIKE ?';
    $params[] = '%' . $cliente . '%';
}

if ($vehiculo !== '') {
    $conditions[] = 'f.vehiculo LIKE ?';
    $params[] = '%' . $vehiculo . '%';
}

if ($mecanico !== '') {
    $conditions[] = 'm.id = ?';
    $params[] = (int) $mecanico;
}

if ($dateFrom !== '') {
    $conditions[] = 'f.fecha >= ?';
    $params[] = $dateFrom;
}

if ($dateTo !== '') {
    $conditions[] = 'f.fecha <= ?';
    $params[] = $dateTo;
}

$sql = "SELECT
    f.id,
    f.fecha,
    f.cliente,
    f.vehiculo,
    f.total,
    f.tipo_mantenimiento,
    m.nombre AS mecanico,
    COUNT(df.id) AS servicios_count,
    GROUP_CONCAT(DISTINCT s.nombre ORDER BY s.nombre SEPARATOR ', ') AS servicios
FROM facturas f
LEFT JOIN mecanicos m ON f.mecanico_id = m.id
LEFT JOIN detalle_factura df ON df.factura_id = f.id
LEFT JOIN servicios s ON s.id = df.servicio_id";

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$sql .= ' GROUP BY f.id ORDER BY f.fecha DESC, f.id DESC';

$facturas = $model->executeQuery($sql, $params);

$verId = isset($_GET['ver']) ? (int) $_GET['ver'] : 0;
$facturaDetalle = null;
$detalleServicios = [];

if ($verId > 0) {
    $detalleRows = $model->executeQuery(
        'SELECT f.*, m.nombre AS mecanico, m.experiencia, m.rating
         FROM facturas f
         LEFT JOIN mecanicos m ON f.mecanico_id = m.id
         WHERE f.id = ? LIMIT 1',
        [$verId]
    );

    if (!empty($detalleRows)) {
        $facturaDetalle = $detalleRows[0];
        $detalleServicios = $model->executeQuery(
            'SELECT s.nombre, df.precio
             FROM detalle_factura df
             LEFT JOIN servicios s ON s.id = df.servicio_id
             WHERE df.factura_id = ?',
            [$verId]
        );
    }
}

function buildQueryString(array $filters): string {
    return http_build_query(array_filter($filters, fn($value) => $value !== ''));
}

$filterQuery = buildQueryString([
    'cliente' => $cliente,
    'vehiculo' => $vehiculo,
    'mecanico' => $mecanico,
    'date_from' => $dateFrom,
    'date_to' => $dateTo,
]);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Facturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body class="bg-light">

<div class="container py-5">

    <?php require_once __DIR__ . '/partials/flash_messages.php'; ?>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="fw-bold text-primary">📜 Historial de Facturas</h1>
            <p class="text-muted mb-0">Consulta facturas anteriores, filtra por cliente, vehículo o fecha.</p>
        </div>
        <a href="dashboard_view.php" class="btn btn-secondary">⬅ Volver al panel</a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">Cliente</label>
                    <input type="text" name="cliente" class="form-control" value="<?= htmlspecialchars($cliente) ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Vehículo</label>
                    <input type="text" name="vehiculo" class="form-control" value="<?= htmlspecialchars($vehiculo) ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Mecánico</label>
                    <input type="text" name="mecanico" class="form-control" value="<?= htmlspecialchars($mecanico) ?>" placeholder="ID mecánico">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Desde</label>
                    <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars($dateFrom) ?>">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars($dateTo) ?>">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="historial_view.php" class="btn btn-outline-secondary">Limpiar</a>
                </div>

            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Facturas encontradas: <?= count($facturas) ?></h4>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Mecánico</th>
                            <th>Servicios</th>
                            <th>Total</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($facturas)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">No se encontraron facturas.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($facturas as $factura): ?>
                                <tr>
                                    <td><?= htmlspecialchars($factura['id']) ?></td>
                                    <td><?= htmlspecialchars($factura['fecha']) ?></td>
                                    <td><?= htmlspecialchars($factura['cliente']) ?></td>
                                    <td><?= htmlspecialchars($factura['vehiculo']) ?></td>
                                    <td><?= htmlspecialchars($factura['mecanico'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($factura['servicios_count']) ?></td>
                                    <td>$<?= number_format((float) $factura['total'], 2) ?></td>
                                    <td>
                                        <a href="historial_view.php?ver=<?= (int) $factura['id'] ?>&<?= $filterQuery ?>" class="btn btn-sm btn-primary">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if ($facturaDetalle): ?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="fw-bold">Detalle de factura #<?= htmlspecialchars($facturaDetalle['id']) ?></h4>
                        <p class="text-muted mb-1">Cliente: <?= htmlspecialchars($facturaDetalle['cliente']) ?></p>
                        <p class="text-muted mb-0">Vehículo: <?= htmlspecialchars($facturaDetalle['vehiculo']) ?></p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary">Total: $<?= number_format((float) $facturaDetalle['total'], 2) ?></span>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Fecha:</strong> <?= htmlspecialchars($facturaDetalle['fecha']) ?></p>
                        <p class="mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($facturaDetalle['tipo_mantenimiento']) ?></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Mecánico:</strong> <?= htmlspecialchars($facturaDetalle['mecanico'] ?? 'N/A') ?></p>
                        <p class="mb-1"><strong>Experiencia:</strong> <?= htmlspecialchars($facturaDetalle['experiencia'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1"><strong>Rating:</strong> <?= htmlspecialchars($facturaDetalle['rating'] ?? '-') ?></p>
                    </div>
                </div>

                <h5 class="mb-3">Servicios</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Servicio</th>
                                <th class="text-end">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detalleServicios as $servicio): ?>
                                <tr>
                                    <td><?= htmlspecialchars($servicio['nombre'] ?? 'N/A') ?></td>
                                    <td class="text-end">$<?= number_format((float) $servicio['precio'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-end">
                    <a href="historial_view.php?<?= $filterQuery ?>" class="btn btn-outline-secondary">Cerrar detalle</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
