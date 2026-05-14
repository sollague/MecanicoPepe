<?php
session_start();

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

$vehiculos = $model->executeQuery(
    "SELECT * FROM vehiculos"
);

$editar = null;

if (isset($_GET['editar'])) {

    $idEditar = (int)$_GET['editar'];

    if ($idEditar > 0) {
        $resultado = $model->executeQuery(
            "SELECT * FROM vehiculos WHERE id = $idEditar"
        );

        if (!empty($resultado)) {
            $editar = $resultado[0];
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Vehículos</title>
    <link rel="stylesheet" href="../styles/style.css">
    
</head>

<body>

<div class="container">

    <h2>Registro de Vehículos</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h3><?= $editar ? "Editar Vehículo" : "Registrar Nuevo Vehículo" ?></h3>

    <form method="POST" action="../controllers/VehiculoController.php">

        <?php if ($editar): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editar['id']) ?>">
        <?php endif; ?>

        <input type="text"
               name="marca"
               placeholder="Marca (ej: Toyota)"
               value="<?= htmlspecialchars($editar['marca'] ?? '') ?>"
               required>

        <input type="text"
               name="modelo"
               placeholder="Modelo (ej: Corolla)"
               value="<?= htmlspecialchars($editar['modelo'] ?? '') ?>"
               required>

        <input type="number"
               name="anio"
               placeholder="Año (ej: 2023)"
               value="<?= htmlspecialchars($editar['anio'] ?? '') ?>"
               required
               min="1900"
               max="2100">

        <input type="text"
               name="placa"
               placeholder="Placa (ej: ABC-1234)"
               value="<?= htmlspecialchars($editar['placa'] ?? '') ?>"
               required>

        <input type="text"
               name="propietario"
               placeholder="Propietario (nombre completo)"
               value="<?= htmlspecialchars($editar['propietario'] ?? '') ?>"
               required>

        <?php if ($editar): ?>
            <button type="submit" name="editar" value="1">
                Actualizar Vehículo
            </button>
        <?php else: ?>
            <button type="submit" name="crear" value="1">
                ➕ Registrar Nuevo Vehículo
            </button>
        <?php endif; ?>

    </form>

    <hr>

    <h3>Vehículos Registrados</h3>

    <?php if (!empty($vehiculos)): ?>

        <table>

            <thead>
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
                    <td><?= htmlspecialchars($v['id']) ?></td>
                    <td><?= htmlspecialchars($v['marca']) ?></td>
                    <td><?= htmlspecialchars($v['modelo']) ?></td>
                    <td><?= htmlspecialchars($v['anio']) ?></td>
                    <td><strong><?= htmlspecialchars($v['placa']) ?></strong></td>
                    <td><?= htmlspecialchars($v['propietario']) ?></td>

                    <td>
                        <a href="?editar=<?= htmlspecialchars($v['id']) ?>">Editar</a>
                        |
                        <a href="../controllers/VehiculoController.php?eliminar=<?= htmlspecialchars($v['id']) ?>"
                           onclick="return confirm('¿Estás seguro de que deseas eliminar este vehículo?');" class="btn-delete" >
                            Eliminar
                        </a>
                    </td>
                </tr>

                <?php endforeach; ?>
            </tbody>

        </table>

    <?php else: ?>

        <div class="alert alert-success" style="text-align: center;">
            <p>No hay vehículos registrados aún.</p>
        </div>

    <?php endif; ?>

    <br>

    <a href="dashboard_view.php" style="font-size: 16px;">
        Volver al Dashboard
    </a>

</div>

</body>

</html>