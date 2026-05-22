<?php

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| BUSCADOR
|--------------------------------------------------------------------------
*/

$busqueda = "";

if (isset($_GET['buscar'])) {

    $busqueda = $_GET['buscar'];

    $sql = "
    SELECT * FROM repuestos
    WHERE nombre LIKE '%$busqueda%'
    ";

} else {

    $sql = "
    SELECT * FROM repuestos
    ";
}

/*
|--------------------------------------------------------------------------
| OBTENER REPUESTOS
|--------------------------------------------------------------------------
*/

$repuestos = $model->executeQuery($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Inventario</title>

    <link rel="stylesheet"
          href="../styles/style.css">

</head>

<body>

<div class="container">

    <h2>Inventario de Repuestos</h2>

    <!-- ================= BUSCADOR ================= -->

    <form method="GET">

        <input type="text"
               name="buscar"
               placeholder="Buscar repuesto..."
               value="<?= $busqueda ?>">

        <button type="submit" class="btn-buscar">
            Buscar
        </button>

    </form>

    <br>

    <!-- ================= TABLA ================= -->

    <table>

        <tr>
            <th>Repuesto</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Estado</th>
        </tr>

        <?php foreach ($repuestos as $r): ?>

            <tr>

                <td><?= $r['nombre'] ?></td>

                <td><?= $r['stock'] ?></td>

                <td>$<?= $r['precio'] ?></td>

                <td>

                    <?php
                    if ($r['stock'] <= 3) {

                        echo "🔴 Bajo";

                    } elseif ($r['stock'] <= 8) {

                        echo "🟡 Medio";

                    } else {

                        echo "🟢 Disponible";
                    }
                    ?>

                </td>

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