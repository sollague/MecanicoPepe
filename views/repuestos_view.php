<?php

<<<<<<< HEAD
require_once "../models/MecanicoPepe.php";

$model = new MecanicoPepe();

=======
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
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
/*
|--------------------------------------------------------------------------
| BUSCADOR
|--------------------------------------------------------------------------
*/

$busqueda = "";

<<<<<<< HEAD
if (isset($_GET["buscar"])) {
    $busqueda = $_GET["buscar"];
=======
if (isset($_GET['buscar'])) {

    $busqueda = $_GET['buscar'];
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

    $sql = "
    SELECT * FROM repuestos
    WHERE nombre LIKE '%$busqueda%'
    ";
<<<<<<< HEAD
} else {
=======

} else {

>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
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

<<<<<<< HEAD
/*
|--------------------------------------------------------------------------
| EDITAR
|--------------------------------------------------------------------------
*/

$editar = null;

if (isset($_GET["editar"])) {
    $idEditar = $_GET["editar"];

    $resultado = $model->executeQuery(
        "SELECT * FROM repuestos WHERE id = $idEditar",
    );

    if (!empty($resultado)) {
        $editar = $resultado[0];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Inventario</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <!-- TITULO -->

    <div class="text-center mb-5">

        <h1 class="fw-bold text-primary">
            ⚙️ Inventario de Repuestos
        </h1>

        <p class="text-muted">
            Administración y control de inventario
        </p>

    </div>

    <!-- FORMULARIO -->

    <div class="card shadow border-0 mb-5">

        <div class="card-body p-4">

            <h3 class="mb-4">

                <?= $editar ? "✏️ Editar Repuesto" : "➕ Agregar Repuesto" ?>

            </h3>

            <form method="POST"
                  action="../controllers/RepuestoController.php">

                <?php if ($editar): ?>

                    <input type="hidden"
                           name="id"
                           value="<?= $editar["id"] ?>">

                <?php endif; ?>

                <div class="row">

                    <!-- NOMBRE -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Nombre
                        </label>

                        <input type="text"
                               name="nombre"
                               class="form-control"
                               placeholder="Nombre del repuesto"
                               value="<?= $editar["nombre"] ?? "" ?>"
                               required>

                    </div>

                    <!-- PRECIO -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Precio
                        </label>

                        <input type="number"
                               step="0.01"
                               name="precio"
                               class="form-control"
                               placeholder="0.00"
                               value="<?= $editar["precio"] ?? "" ?>"
                               required>

                    </div>

                    <!-- STOCK -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Stock
                        </label>

                        <input type="number"
                               name="stock"
                               class="form-control"
                               placeholder="Cantidad disponible"
                               value="<?= $editar["stock"] ?? "" ?>"
                               required>

                    </div>

                </div>

                <!-- BOTON -->

                <?php if ($editar): ?>

                    <button type="submit"
                            name="editar"
                            class="btn btn-warning">

                        Actualizar

                    </button>

                <?php else: ?>

                    <button type="submit"
                            name="crear"
                            class="btn btn-primary">

                        Agregar

                    </button>

                <?php endif; ?>

            </form>

        </div>

    </div>

    <!-- BUSCADOR -->

    <div class="card shadow border-0 mb-4">

        <div class="card-body p-4">

            <h3 class="mb-3">
                🔍 Buscar Repuestos
            </h3>

            <form method="GET"
                  class="row g-3">

                <div class="col-md-10">

                    <input type="text"
                           name="buscar"
                           id="buscador"
                           class="form-control"
                           placeholder="Buscar repuesto..."
                           value="<?= $busqueda ?>">

                </div>

                <div class="col-md-2">

                    <button type="submit"
                            class="btn btn-dark w-100">

                        Buscar

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- TABLA -->

    <div class="card shadow border-0">

        <div class="card-body p-4">

            <h3 class="mb-4">
                📦 Inventario Actual
            </h3>

            <div class="table-responsive">

                <table class="table table-hover align-middle"
                       id="tablaRepuestos">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($repuestos as $r): ?>

                        <tr>

                            <td>
                                <?= $r["id"] ?>
                            </td>

                            <td class="fw-semibold">
                                <?= $r["nombre"] ?>
                            </td>

                            <td class="text-success fw-bold">
                                $<?= $r["precio"] ?>
                            </td>

                            <td>
                                <?= $r["stock"] ?>
                            </td>

                            <td>

                                <?php if ($r["stock"] <= 3) {
                                    echo '<span class="badge bg-danger">Bajo</span>';
                                } elseif ($r["stock"] <= 8) {
                                    echo '<span class="badge bg-warning text-dark">Medio</span>';
                                } else {
                                    echo '<span class="badge bg-success">Disponible</span>';
                                } ?>

                            </td>

                            <td>

                                <a href="?editar=<?= $r["id"] ?>"
                                   class="btn btn-sm btn-warning">

                                    Editar

                                </a>

                                <a href="../controllers/RepuestoController.php?eliminar=<?= $r[
                                    "id"
                                ] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('¿Estás seguro de que deseas eliminar este repuesto?');">

                                    Eliminar

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

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

<!-- BUSCADOR DINAMICO -->

=======
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
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
<script>

const buscador =
document.getElementById("buscador");

buscador.addEventListener("keyup", function () {

    let texto =
    buscador.value.toLowerCase();

    let filas =
    document.querySelectorAll(
<<<<<<< HEAD
        "#tablaRepuestos tbody tr"
    );

    filas.forEach((fila) => {
=======
        "#tablaRepuestos tr"
    );

    filas.forEach((fila, index) => {

        // Saltar encabezado
        if (index === 0) return;
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

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

<<<<<<< HEAD
</body>

</html>
=======

</body>
=======

</body>

>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
</html>
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
