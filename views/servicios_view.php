<?php

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| OBTENER SERVICIOS
|--------------------------------------------------------------------------
*/

$servicios = $model->executeQuery(
    "SELECT * FROM servicios"
);

/*
|--------------------------------------------------------------------------
| OBTENER MECÁNICOS
|--------------------------------------------------------------------------
*/

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