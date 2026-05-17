<?php
session_start();

require_once "../models/MecanicoPepe.php";

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| OBTENER VEHÍCULOS
|--------------------------------------------------------------------------
*/

$vehiculos = $model->executeQuery("SELECT * FROM vehiculos");

$editar = null;

if (isset($_GET["editar"])) {
    $idEditar = (int) $_GET["editar"];

    if ($idEditar > 0) {
        $resultado = $model->executeQuery(
            "SELECT * FROM vehiculos WHERE id = $idEditar",
        );

        if (!empty($resultado)) {
            $editar = $resultado[0];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Vehículos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <!-- TITULO -->
    <div class="text-center mb-5">

        <h1 class="fw-bold text-primary">
            🚗 Registro de Vehículos
        </h1>

        <p class="text-muted">
            Gestión de vehículos del taller
        </p>

    </div>

    <!-- ALERTAS -->

    <?php if (isset($_SESSION["success"])): ?>

        <div class="alert alert-success alert-dismissible fade show">

            <?= htmlspecialchars($_SESSION["success"]) ?>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

        <?php unset($_SESSION["success"]); ?>

    <?php endif; ?>

    <?php if (isset($_SESSION["error"])): ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <?= htmlspecialchars($_SESSION["error"]) ?>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

        <?php unset($_SESSION["error"]); ?>

    <?php endif; ?>

    <!-- FORMULARIO -->

    <div class="card shadow border-0 mb-5">

        <div class="card-body p-4">

            <h3 class="mb-4">

                <?= $editar
                    ? "✏️ Editar Vehículo"
                    : "➕ Registrar Nuevo Vehículo" ?>

            </h3>

            <form method="POST"
                  action="../controllers/VehiculoController.php">

                <?php if ($editar): ?>

                    <input type="hidden"
                           name="id"
                           value="<?= htmlspecialchars($editar["id"]) ?>">

                <?php endif; ?>

                <div class="row">

                    <!-- MARCA -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Marca
                        </label>

                        <input type="text"
                               name="marca"
                               class="form-control"
                               placeholder="Toyota"
                               value="<?= htmlspecialchars(
                                   $editar["marca"] ?? "",
                               ) ?>"
                               required>

                    </div>

                    <!-- MODELO -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Modelo
                        </label>

                        <input type="text"
                               name="modelo"
                               class="form-control"
                               placeholder="Corolla"
                               value="<?= htmlspecialchars(
                                   $editar["modelo"] ?? "",
                               ) ?>"
                               required>

                    </div>

                    <!-- AÑO -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Año
                        </label>

                        <input type="number"
                               name="anio"
                               class="form-control"
                               placeholder="2023"
                               value="<?= htmlspecialchars(
                                   $editar["anio"] ?? "",
                               ) ?>"
                               required
                               min="1900"
                               max="2100">

                    </div>

                    <!-- PLACA -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Placa
                        </label>

                        <input type="text"
                               name="placa"
                               class="form-control"
                               placeholder="ABC-1234"
                               value="<?= htmlspecialchars(
                                   $editar["placa"] ?? "",
                               ) ?>"
                               required>

                    </div>

                    <!-- PROPIETARIO -->
                    <div class="col-12 mb-4">

                        <label class="form-label">
                            Propietario
                        </label>

                        <input type="text"
                               name="propietario"
                               class="form-control"
                               placeholder="Nombre completo"
                               value="<?= htmlspecialchars(
                                   $editar["propietario"] ?? "",
                               ) ?>"
                               required>

                    </div>

                </div>

                <!-- BOTON -->

                <?php if ($editar): ?>

                    <button type="submit"
                            name="editar"
                            value="1"
                            class="btn btn-warning">

                        Actualizar Vehículo

                    </button>

                <?php else: ?>

                    <button type="submit"
                            name="crear"
                            value="1"
                            class="btn btn-primary">

                        Registrar Vehículo

                    </button>

                <?php endif; ?>

            </form>

        </div>

    </div>

    <!-- TABLA -->

    <div class="card shadow border-0">

        <div class="card-body p-4">

            <h3 class="mb-4">
                📋 Vehículos Registrados
            </h3>

            <?php if (!empty($vehiculos)): ?>

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Año</th>
                                <th>Placa</th>
                                <th>Propietario</th>
                                <th>Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php foreach ($vehiculos as $v): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($v["id"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($v["marca"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($v["modelo"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($v["anio"]) ?>
                                </td>

                                <td>

                                    <span class="badge bg-primary">

                                        <?= htmlspecialchars($v["placa"]) ?>

                                    </span>

                                </td>

                                <td>
                                    <?= htmlspecialchars($v["propietario"]) ?>
                                </td>

                                <td>

                                    <a href="?editar=<?= htmlspecialchars(
                                        $v["id"],
                                    ) ?>"
                                       class="btn btn-sm btn-warning">

                                        Editar

                                    </a>

                                    <a href="../controllers/VehiculoController.php?eliminar=<?= htmlspecialchars(
                                        $v["id"],
                                    ) ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Deseas eliminar este vehículo?');">

                                        Eliminar

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="alert alert-info text-center mb-0">

                    No hay vehículos registrados aún.

                </div>

            <?php endif; ?>

        </div>

    </div>

    <!-- VOLVER -->

    <div class="text-center mt-4">

        <a href="dashboard_view.php"
           class="btn btn-secondary">

            ⬅ Volver al Dashboard

        </a>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
