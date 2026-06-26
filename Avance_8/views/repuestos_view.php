<?php

require_once "../models/MecanicoPepe.php";

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| BUSCADOR
|--------------------------------------------------------------------------
*/

$busqueda = "";

if (isset($_GET["buscar"])) {
    $busqueda = $_GET["buscar"];

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventario</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">

</head>

<body class="bg-light">

<div class="container py-5">

    <?php require_once __DIR__ . '/partials/flash_messages.php'; ?>

    <!-- Vista de inventario de repuestos con formulario y tabla -->
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

            <form method="POST" action="../controllers/RepuestoController.php">

                <?php if ($editar): ?>
                    <input type="hidden" name="id" value="<?= $editar["id"] ?>">
                <?php endif; ?>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control"
                               value="<?= $editar["nombre"] ?? "" ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control"
                               value="<?= $editar["precio"] ?? "" ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control"
                               value="<?= $editar["stock"] ?? "" ?>" required>
                    </div>

                </div>

                <?php if ($editar): ?>
                    <button type="submit" name="editar" class="btn btn-warning">Actualizar</button>
                <?php else: ?>
                    <button type="submit" name="crear" class="btn btn-primary">Agregar</button>
                <?php endif; ?>

            </form>

        </div>

    </div>

    <!-- BUSCADOR -->
    <div class="card shadow border-0 mb-4">

        <div class="card-body p-4">

            <h3 class="mb-3">🔍 Buscar Repuestos</h3>

            <input type="text"
                   id="buscador"
                   class="form-control"
                   placeholder="Buscar repuesto..."
                   value="<?= $busqueda ?>">

        </div>

    </div>

    <!-- TABLA -->
    <div class="card shadow border-0">

        <div class="card-body p-4">

            <h3 class="mb-4">📦 Inventario Actual</h3>

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="tablaRepuestos">

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

                            <td><?= $r["id"] ?></td>
                            <td class="fw-semibold"><?= $r["nombre"] ?></td>
                            <td class="text-success">$<?= $r["precio"] ?></td>
                            <td><?= $r["stock"] ?></td>

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
                                <a href="?editar=<?= $r[
                                    "id"
                                ] ?>" class="btn btn-sm btn-warning">Editar</a>

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

    <div class="text-center mt-4">
        <a href="dashboard_view.php" class="btn btn-secondary">⬅ Volver</a>
    </div>

</div>

<script>

const buscador = document.getElementById("buscador");

buscador.addEventListener("keyup", function () {

    let texto = buscador.value.toLowerCase();
    let filas = document.querySelectorAll("#tablaRepuestos tbody tr");

    filas.forEach((fila) => {

        let contenido = fila.textContent.toLowerCase();

        fila.style.display = contenido.includes(texto) ? "" : "none";
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
