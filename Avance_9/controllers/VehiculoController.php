<?php

/**
 * VehiculoController
 *
 * Controlador encargado de procesar el formulario de vehículos y las
 * acciones de crear, editar y eliminar registros en la tabla de vehículos.
 */
session_start();
require_once "../models/MecanicoPepe.php";
require_once "../models/Validator.php";
require_once "../models/Response.php";
require_once "../models/Logger.php";

try {
    $model = new MecanicoPepe();
} catch (Exception $e) {
    Logger::error("Error al inicializar modelo de vehículos: " . $e->getMessage());
    Response::withError(
        "❌ No se puede conectar a la base de datos. Intenta más tarde",
        "../views/vehiculos_view.php"
    );
}

// Crear un nuevo vehículo cuando se envía el formulario de creación.
// ============================================================
// CREAR VEHÍCULO
// ============================================================
if (isset($_POST["crear"])) {
    if (!Validator::required(["marca", "modelo", "anio", "placa", "propietario"], $_POST)) {
        Response::withError("❌ Todos los campos son obligatorios", "../views/vehiculos_view.php");
    }

    if (!Validator::isPositiveNumber($_POST["anio"], 1900)) {
        Response::withError("❌ El año debe ser un número válido (mínimo 1900)", "../views/vehiculos_view.php");
    }

    try {
        $sql = "INSERT INTO vehiculos (marca, modelo, anio, placa, propietario) VALUES (?, ?, ?, ?, ?)";
        $parametros = [
            Validator::sanitizeText($_POST["marca"]),
            Validator::sanitizeText($_POST["modelo"]),
            (int) $_POST["anio"],
            Validator::sanitizeText($_POST["placa"]),
            Validator::sanitizeText($_POST["propietario"]),
        ];

        $result = $model->executeNonQueryPrepared($sql, $parametros);

        if ($result === false) {
            throw new Exception("No se pudo insertar el vehículo");
        }

        Response::withSuccess("✅ Vehículo registrado correctamente", "../views/vehiculos_view.php");
    } catch (Exception $e) {
        Logger::error("Error al crear vehículo: " . $e->getMessage());
        Response::withError("❌ No se pudo registrar el vehículo. Intenta de nuevo", "../views/vehiculos_view.php");
    }
}

// Actualizar un vehículo existente cuando se envía el formulario de edición.
if (isset($_POST["editar"])) {
    if (!Validator::required(["id", "marca", "modelo", "anio", "placa", "propietario"], $_POST)) {
        Response::withError("❌ Todos los campos son obligatorios", "../views/vehiculos_view.php");
    }

    if (!Validator::isValidId($_POST["id"])) {
        Response::withError("❌ ID inválido", "../views/vehiculos_view.php");
    }

    if (!Validator::isPositiveNumber($_POST["anio"], 1900)) {
        Response::withError("❌ El año debe ser un número válido (mínimo 1900)", "../views/vehiculos_view.php");
    }

    try {
        $sql = "UPDATE vehiculos SET marca = ?, modelo = ?, anio = ?, placa = ?, propietario = ? WHERE id = ?";
        $parametros = [
            Validator::sanitizeText($_POST["marca"]),
            Validator::sanitizeText($_POST["modelo"]),
            (int) $_POST["anio"],
            Validator::sanitizeText($_POST["placa"]),
            Validator::sanitizeText($_POST["propietario"]),
            (int) $_POST["id"],
        ];

        $result = $model->executeNonQueryPrepared($sql, $parametros);

        if ($result === false) {
            throw new Exception("No se pudo actualizar el vehículo");
        }

        Response::withSuccess("✅ Vehículo actualizado correctamente", "../views/vehiculos_view.php");
    } catch (Exception $e) {
        Logger::error("Error al editar vehículo: " . $e->getMessage());
        Response::withError("❌ No se pudo actualizar el vehículo. Intenta de nuevo", "../views/vehiculos_view.php");
    }
}

// Eliminar vehículo identificado por parámetro GET.
if (isset($_GET["eliminar"])) {
    if (!Validator::isValidId($_GET["eliminar"])) {
        Response::withError("❌ ID inválido", "../views/vehiculos_view.php");
    }

    $id = (int) $_GET["eliminar"];

    try {
        $sql = "DELETE FROM vehiculos WHERE id = ?";
        $result = $model->executeNonQueryPrepared($sql, [$id]);

        if ($result === false) {
            throw new Exception("No se pudo eliminar el vehículo");
        }

        Response::withSuccess("✅ Vehículo eliminado correctamente", "../views/vehiculos_view.php");
    } catch (Exception $e) {
        Logger::error("Error al eliminar vehículo: " . $e->getMessage());
        Response::withError("❌ No se pudo eliminar el vehículo. Intenta de nuevo", "../views/vehiculos_view.php");
    }
}

Response::withError("❌ Acción no reconocida", "../views/vehiculos_view.php");
?>
