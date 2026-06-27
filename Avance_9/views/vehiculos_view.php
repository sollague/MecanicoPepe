<?php

session_start();
require_once "../models/MecanicoPepe.php";

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| OBTENER VEHÍCULOS
|--------------------------------------------------------------------------
*/

$vehiculos = $model->executeQuery("SELECT * FROM vehiculos ORDER BY id DESC");

/*
|--------------------------------------------------------------------------
| EDITAR VEHÍCULO
|--------------------------------------------------------------------------
*/

$editar = null;

if (isset($_GET["editar"])) {
    $id = (int) $_GET["editar"];

    if ($id > 0) {
        $res = $model->executeQuery("SELECT * FROM vehiculos WHERE id = $id");

        if (!empty($res)) {
            $editar = $res[0];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehículos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body class="bg-light">

<div class="container py-5">

    <?php require_once __DIR__ . '/partials/flash_messages.php'; ?>

    <!-- TITULO -->
    <div class="text-center mb-4">
        <h1 class="fw-bold text-primary">🚗 Registro de Vehículos</h1>
        <p class="text-muted">Gestión de vehículos del taller</p>
    </div>

    <!-- ALERTA -->
    <?php if (isset($_SESSION["success"])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION["success"]) ?>
        </div>
        <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>

    <!-- FORMULARIO -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body p-4">

            <h3 class="mb-3">
                <?= $editar ? "✏️ Editar Vehículo" : "➕ Registrar Vehículo" ?>
            </h3>

            <form method="POST" action="../controllers/VehiculoController.php">

                <?php if ($editar): ?>
                    <input type="hidden" name="id" value="<?= $editar["id"] ?>">
                <?php endif; ?>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cliente</label>
                        <input type="text" name="cliente" class="form-control"
                               value="<?= $editar["cliente"] ?? "" ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="marca" class="form-control"
                               value="<?= $editar["marca"] ?? "" ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo" class="form-control"
                               value="<?= $editar["modelo"] ?? "" ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Año</label>
                        <input type="number" name="anio" class="form-control"
                               value="<?= $editar["anio"] ?? "" ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Propietario</label>
                        <input type="text" name="propietario" class="form-control"
                               value="<?= $editar["propietario"] ?? "" ?>" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Placa</label>
                        <input type="text" name="placa" class="form-control"
                               value="<?= $editar["placa"] ?? "" ?>" required>
                    </div>

                </div>

                <?php if ($editar): ?>
                    <button type="submit" name="editar" class="btn btn-warning">
                        Actualizar
                    </button>
                <?php else: ?>
                    <button type="submit" name="crear" class="btn btn-primary">
                        Guardar
                    </button>
                <?php endif; ?>

            </form>

        </div>
    </div>

    <!-- TABLA -->
    <div class="card shadow border-0">
        <div class="card-body p-4">

            <h3 class="mb-3">📋 Vehículos Registrados</h3>

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Placa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($vehiculos as $v): ?>
                            <tr>
                                <td><?= $v["id"] ?></td>
                                <td><?= $v["cliente"] ?></td>
                                <td><?= $v["marca"] ?></td>
                                <td><?= $v["modelo"] ?></td>
                                <td><?= $v["anio"] ?></td>
                                <td><span class="badge bg-primary"><?= $v[
                                    "placa"
                                ] ?></span></td>

                                <td>
                                    <a href="?editar=<?= $v[
                                        "id"
                                    ] ?>" class="btn btn-warning btn-sm">Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>

        </div>
    </div>

    <div class="text-center mt-4">
        <a href="dashboard_view.php" class="btn btn-secondary">
            ⬅ Volver
        </a>
    </div>

</div>

</body>
</html>
