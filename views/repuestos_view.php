<?php

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

<<<<<<< HEAD
$repuestos = $model->executeQuery(
    "SELECT * FROM repuestos"
);

$editar = null;

if (isset($_GET['editar'])) {

    $idEditar = $_GET['editar'];

    $resultado = $model->executeQuery(
        "SELECT * FROM repuestos WHERE id = $idEditar"
    );

    $editar = $resultado[0];
}
=======
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

>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
?>

<!DOCTYPE html>
<html>

<head>

    <title>Inventario</title>

<<<<<<< HEAD
    <link rel="stylesheet" href="../styles/style.css">
=======
    <link rel="stylesheet"
          href="../styles/style.css">
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c

</head>

<body>

<div class="container">

    <h2>Inventario de Repuestos</h2>

<<<<<<< HEAD
    <!-- FORMULARIO -->

    <form method="POST"
          action="../controllers/RepuestoController.php">

        <?php if ($editar): ?>

            <input type="hidden"
                   name="id"
                   value="<?= $editar['id'] ?>">

        <?php endif; ?>

        <input type="text"
               name="nombre"
               placeholder="Nombre"
               value="<?= $editar['nombre'] ?? '' ?>"
               required>

        <input type="number"
               step="0.01"
               name="precio"
               placeholder="Precio"
               value="<?= $editar['precio'] ?? '' ?>"
               required>

        <input type="number"
               name="stock"
               placeholder="Stock"
               value="<?= $editar['stock'] ?? '' ?>"
               required>

        <?php if ($editar): ?>

            <button type="submit" name="editar">
                Actualizar
            </button>

        <?php else: ?>

            <button type="submit" name="crear">
                Agregar
            </button>

        <?php endif; ?>

    </form>

    <h3>Busca Repuestos</h3>

    <input type="text" id="buscador" placeholder="Buscar repuesto..."class="search-input">

    <hr>

    <!-- TABLA -->

    <table id="tablaRepuestos">

    <thead>

        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>

    </thead>

    <tbody>

        <?php foreach ($repuestos as $r): ?>

        <tr>

            <td><?= $r['id'] ?></td>

            <td><?= $r['nombre'] ?></td>

            <td>$<?= $r['precio'] ?></td>

            <td><?= $r['stock'] ?></td>

            <td>

                <a href="?editar=<?= $r['id'] ?>">
                    Editar
                </a>

                |

                <a href="../controllers/RepuestoController.php?eliminar=<?= $r['id'] ?>" class="btn-delete" 
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este repuesto?');">Eliminar</a>
            </td>

        </tr>

        <?php endforeach; ?>

    </tbody>

</table>
=======
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
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c

    <br>

    <a href="dashboard_view.php">
        ⬅ Volver
    </a>

</div>
<<<<<<< HEAD
<script>

const buscador =
document.getElementById("buscador");

buscador.addEventListener("keyup", function () {

    let texto =
    buscador.value.toLowerCase();

    let filas =
    document.querySelectorAll(
        "#tablaRepuestos tr"
    );

    filas.forEach((fila, index) => {

        // Saltar encabezado
        if (index === 0) return;

        let contenido =
        fila.textContent.toLowerCase();

        if (contenido.includes(texto)) {

            fila.style.display = "";

        } else {

            fila.style.display = "none";
        }
    });
});

</script>


</body>
=======

</body>

>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
</html>