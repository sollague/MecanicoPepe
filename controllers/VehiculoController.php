<?php
session_start();

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| CREAR VEHÍCULO
|--------------------------------------------------------------------------
*/

if (isset($_POST['crear'])) {

    // Validar campos vacíos
    if (empty($_POST['marca']) || empty($_POST['modelo']) || empty($_POST['anio']) || 
        empty($_POST['placa']) || empty($_POST['propietario'])) {
        $_SESSION['error'] = "❌ Todos los campos son obligatorios";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    try {
        $sql = "INSERT INTO vehiculos (marca, modelo, anio, placa, propietario) 
                VALUES (?, ?, ?, ?, ?)";

        $parametros = [
            trim($_POST['marca']),
            trim($_POST['modelo']),
            (int)$_POST['anio'],
            trim($_POST['placa']),
            trim($_POST['propietario'])
        ];

        $model->executeNonQueryPrepared($sql, $parametros);
        $_SESSION['success'] = "✅ Vehículo registrado correctamente";

    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error al registrar: " . $e->getMessage();
    }

    header("Location: ../views/vehiculos_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| EDITAR VEHÍCULO
|--------------------------------------------------------------------------
*/

if (isset($_POST['editar'])) {

    // Validar campos vacíos
    if (empty($_POST['id']) || empty($_POST['marca']) || empty($_POST['modelo']) || 
        empty($_POST['anio']) || empty($_POST['placa']) || empty($_POST['propietario'])) {
        $_SESSION['error'] = "❌ Todos los campos son obligatorios";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    try {
        $sql = "UPDATE vehiculos 
                SET marca = ?, modelo = ?, anio = ?, placa = ?, propietario = ? 
                WHERE id = ?";

        $parametros = [
            trim($_POST['marca']),
            trim($_POST['modelo']),
            (int)$_POST['anio'],
            trim($_POST['placa']),
            trim($_POST['propietario']),
            (int)$_POST['id']
        ];

        $model->executeNonQueryPrepared($sql, $parametros);
        $_SESSION['success'] = "✅ Vehículo actualizado correctamente";

    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error al actualizar: " . $e->getMessage();
    }

    header("Location: ../views/vehiculos_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| ELIMINAR VEHÍCULO
|--------------------------------------------------------------------------
*/

if (isset($_GET['eliminar'])) {

    $id = (int)$_GET['eliminar'];

    if ($id <= 0) {
        $_SESSION['error'] = "❌ ID inválido";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    try {
        $sql = "DELETE FROM vehiculos WHERE id = ?";
        $model->executeNonQueryPrepared($sql, [$id]);
        $_SESSION['success'] = "✅ Vehículo eliminado correctamente";

    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error al eliminar: " . $e->getMessage();
    }

    header("Location: ../views/vehiculos_view.php");
    exit();
}

// Si llegamos aquí, algo no funcionó
$_SESSION['error'] = "❌ Acción no reconocida";
header("Location: ../views/vehiculos_view.php");
exit();
?>