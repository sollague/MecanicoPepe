<?php

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| GUARDAR VEHÍCULO
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $cliente = $_POST['cliente'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $placa = $_POST['placa'];

    $sql = "
    INSERT INTO vehiculos
    (
        cliente,
        marca,
        modelo,
        anio,
        placa
    )
    VALUES
    (
        '$cliente',
        '$marca',
        '$modelo',
        $anio,
        '$placa'
    )
    ";

    $model->executeNonQuery($sql);
}

/*
|--------------------------------------------------------------------------
| OBTENER VEHÍCULOS
|--------------------------------------------------------------------------
*/

$vehiculos = $model->executeQuery(
    "SELECT * FROM vehiculos"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Vehículos</title>

    <link rel="stylesheet"
          href="../styles/style.css">

</head>

<body>

<div class="container">

    <h2>Registro de Vehículos</h2>

    <!-- FORMULARIO -->

    <form method="POST">

        <input type="text"
               name="cliente"
               placeholder="Cliente"
               required>

        <input type="text"
               name="marca"
               placeholder="Marca"
               required>

        <input type="text"
               name="modelo"
               placeholder="Modelo"
               required>

        <input type="number"
               name="anio"
               placeholder="Año"
               required>

        <input type="text"
               name="placa"
               placeholder="Placa"
               required>

        <button type="submit">
            Guardar vehículo
        </button>

    </form>

    <br>

    <!-- TABLA -->

    <table>

        <tr>
            <th>Cliente</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Placa</th>
        </tr>

        <?php foreach ($vehiculos as $v): ?>

            <tr>

                <td><?= $v['cliente'] ?></td>

                <td><?= $v['marca'] ?></td>

                <td><?= $v['modelo'] ?></td>

                <td><?= $v['anio'] ?></td>

                <td><?= $v['placa'] ?></td>

            </tr>

        <?php endforeach; ?>

    </table>

    <br>

    <a href="dashboard_view.php">
        ⬅ Volver
    </a>

</div>

</body>

</html>