<?php

<<<<<<< HEAD
require_once "../models/MecanicoPepe.php";
=======
require_once("../models/MecanicoPepe.php");
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| OBTENER SERVICIOS
|--------------------------------------------------------------------------
*/

<<<<<<< HEAD
$servicios = $model->executeQuery("SELECT * FROM servicios");
=======
$servicios = $model->executeQuery(
    "SELECT * FROM servicios"
);
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

/*
|--------------------------------------------------------------------------
| OBTENER MECÁNICOS
|--------------------------------------------------------------------------
*/

<<<<<<< HEAD
$mecanicos = $model->executeQuery("SELECT * FROM mecanicos");
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Servicios</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <!-- TITULO -->

    <div class="text-center mb-5">

        <h1 class="fw-bold text-primary">
            🧾 Solicitar Servicio
        </h1>

        <p class="text-muted">
            Gestión de servicios automotrices y facturación
        </p>

    </div>

    <form method="POST"
          action="../controllers/ServicioController.php">

        <!-- DATOS CLIENTE -->

        <div class="card shadow border-0 mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">
                    👤 Datos del Cliente
                </h3>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nombre Completo
                        </label>

                        <input type="text"
                               name="cliente"
                               class="form-control"
                               placeholder="Ingrese el nombre completo"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Cédula
                        </label>

                        <input type="text"
                               name="cedula"
                               class="form-control"
                               placeholder="Ingrese la cédula"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Correo Electrónico
                        </label>

                        <input type="email"
                               name="correo"
                               class="form-control"
                               placeholder="correo@ejemplo.com"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Teléfono
                        </label>

                        <input type="text"
                               name="telefono"
                               class="form-control"
                               placeholder="0999999999"
                               required>

                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Vehículo
                        </label>

                        <input type="text"
                               name="vehiculo"
                               class="form-control"
                               placeholder="Ej: Toyota Corolla 2020"
                               required>

                    </div>

                </div>

            </div>

        </div>

        <!-- MECANICOS -->

        <div class="card shadow border-0 mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">
                    🔧 Selecciona un Mecánico
                </h3>

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
                                               required>

                                        <span class="fw-bold fs-5">

                                            <?= $m["nombre"] ?>

                                        </span>

                                    </div>

                                    <hr>

                                    <p class="mb-1">

                                        <strong>Experiencia:</strong>

                                        <?= $m["experiencia"] ?>

                                    </p>

                                    <p class="mb-0">

                                        ⭐ <?= $m["rating"] ?>

                                    </p>

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

                <h3 class="mb-4">
                    ⚙️ Servicios Disponibles
                </h3>

                <div class="row">

                    <?php foreach ($servicios as $s): ?>

                        <div class="col-md-6 mb-3">

                            <label class="card h-100 border shadow-sm">

                                <div class="card-body">

                                    <div class="form-check">

                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="servicios[]"
                                               value="<?= $s["id"] ?>">

                                        <span class="fw-bold">

                                            <?= $s["nombre"] ?>

                                        </span>

                                    </div>

                                    <hr>

                                    <p class="text-success fw-bold mb-2">

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

                <h3 class="mb-4">
                    🛠 Tipo de Mantenimiento
                </h3>

                <div class="form-check mb-3">

                    <input class="form-check-input"
                           type="radio"
                           name="tipo_mantenimiento"
                           value="Preventivo"
                           required>

                    <label class="form-check-label">

                        Preventivo

                    </label>

                </div>

                <div class="form-check">

                    <input class="form-check-input"
                           type="radio"
                           name="tipo_mantenimiento"
                           value="Correctivo"
                           required>

                    <label class="form-check-label">

                        Correctivo

                    </label>

                </div>

            </div>

        </div>

        <!-- TRABAJOS -->

        <div class="card shadow border-0 mb-4">

            <div class="card-body p-4">

                <h3 class="mb-4">
                    📝 Trabajos Realizados
                </h3>

                <textarea name="trabajos"
                          class="form-control"
                          rows="5"
                          placeholder="Describe los trabajos realizados..."
                          required></textarea>

            </div>

        </div>

        <!-- BOTONES -->

        <div class="d-flex gap-3">

            <button type="submit"
                    class="btn btn-primary btn-lg">

                Generar Factura

            </button>

            <a href="dashboard_view.php"
               class="btn btn-secondary btn-lg">

                ⬅ Volver

            </a>

        </div>

    </form>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
=======
$mecanicos = $model->executeQuery(
    "SELECT * FROM mecanicos"
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Servicios</title>
    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

    <div class="container">


        <h2>Solicitar Servicio</h2>

        <!-- FORMULARIO -->

        <form method="POST" action="../controllers/ServicioController.php">

            <!-- DATOS CLIENTE -->

            <h3>Datos del cliente</h3>

            <input type="text" name="cliente" placeholder="Nombre completo" required>

            <input type="text" name="cedula" placeholder="Cédula" required>

            <input type="email" name="correo" placeholder="Correo" required>

            <input type="text" name="telefono" placeholder="Teléfono" required>

            <input type="text" name="vehiculo" placeholder="Vehículo" required>

            <!-- MECÁNICOS -->

            <h3>Selecciona un mecánico</h3>

            <?php foreach ($mecanicos as $m): ?>

            <div class="box">

                <input type="radio" name="mecanico" value="<?= $m['id'] ?>" required>
<<<<<<< HEAD
=======

>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
                <strong>
                    <?= $m['nombre'] ?>
                </strong>

                <br>

                Experiencia:
                <?= $m['experiencia'] ?>

                <br>

                ⭐ <?= $m['rating'] ?>

            </div>

            <?php endforeach; ?>

            <!-- SERVICIOS -->

            <h3>Servicios</h3>

            <?php foreach ($servicios as $s): ?>

            <div class="box">

                <input type="checkbox" name="servicios[]" value="<?= $s['id'] ?>">

                <strong>
                    <?= $s['nombre'] ?>
                </strong>

                - $<?= $s['precio'] ?>

                <br>

                <small>
                    <?= $s['descripcion'] ?>
                </small>

            </div>

            <?php endforeach; ?>

            <h3>Tipo de mantenimiento</h3>

            <div class="radio-group">

                <label class="radio-box">
                    <input type="radio" name="tipo_mantenimiento" value="Preventivo" required>

                    Preventivo
                </label>

                <label class="radio-box">
                    <input type="radio" name="tipo_mantenimiento" value="Correctivo" required>

                    Correctivo
                </label>

            </div>

            <h3>Trabajos realizados</h3>

            <textarea name="trabajos" placeholder="Describe los trabajos realizados..." required></textarea>


            <button type="submit">
                Generar factura
            </button>

        </form>

    </div>

</body>

</html>
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
