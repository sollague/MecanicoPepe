<?php

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

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
?>

<!DOCTYPE html>
<html>

<head>

    <title>Inventario</title>

    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

<div class="container">

    <h2>Inventario de Repuestos</h2>

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

    <br>

    <a href="dashboard_view.php">
        ⬅ Volver
    </a>

</div>
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
</html>