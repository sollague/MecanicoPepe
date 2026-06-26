<?php

session_start();
require_once "../models/MecanicoPepe.php";
require_once "../models/Validator.php";
require_once "../models/Response.php";
require_once "../models/Logger.php";

try {
    $model = new MecanicoPepe();
} catch (Exception $e) {
    Logger::error("Error al inicializar modelo de repuestos: " . $e->getMessage());
    Response::withError(
        "❌ No se puede conectar a la base de datos. Intenta más tarde",
        "../views/repuestos_view.php"
    );
}

if (isset($_POST["crear"])) {
    if (!Validator::required(["nombre", "precio", "stock"], $_POST)) {
        Response::withError("❌ Todos los campos son obligatorios", "../views/repuestos_view.php");
    }

    if (!Validator::isPositiveNumber($_POST["precio"], 0.01)) {
        Response::withError("❌ El precio debe ser un número válido (mayor a 0)", "../views/repuestos_view.php");
    }

    if (!Validator::isPositiveNumber($_POST["stock"], 0)) {
        Response::withError("❌ El stock debe ser un número válido (mayor o igual a 0)", "../views/repuestos_view.php");
    }

    try {
        $sql = "INSERT INTO repuestos (nombre, precio, stock) VALUES (?, ?, ?)";
        $parametros = [
            Validator::sanitizeText($_POST["nombre"]),
            (float) $_POST["precio"],
            (int) $_POST["stock"],
        ];

        $model->executeNonQueryPrepared($sql, $parametros);
        Response::withSuccess("✅ Repuesto registrado correctamente", "../views/repuestos_view.php");
    } catch (Exception $e) {
        Logger::error("Error al crear repuesto: " . $e->getMessage());
        Response::withError("❌ No se pudo registrar el repuesto. Intenta de nuevo", "../views/repuestos_view.php");
    }
}

if (isset($_GET["eliminar"])) {
    if (!Validator::isValidId($_GET["eliminar"])) {
        Response::withError("❌ ID inválido", "../views/repuestos_view.php");
    }

    $id = (int) $_GET["eliminar"];

    try {
        $sql = "DELETE FROM repuestos WHERE id = ?";
        $model->executeNonQueryPrepared($sql, [$id]);
        Response::withSuccess("✅ Repuesto eliminado correctamente", "../views/repuestos_view.php");
    } catch (Exception $e) {
        Logger::error("Error al eliminar repuesto: " . $e->getMessage());
        Response::withError("❌ No se pudo eliminar el repuesto. Intenta de nuevo", "../views/repuestos_view.php");
    }
}

if (isset($_POST["editar"])) {
    if (!Validator::required(["id", "nombre", "precio", "stock"], $_POST)) {
        Response::withError("❌ Todos los campos son obligatorios", "../views/repuestos_view.php");
    }

    if (!Validator::isValidId($_POST["id"])) {
        Response::withError("❌ ID inválido", "../views/repuestos_view.php");
    }

    if (!Validator::isPositiveNumber($_POST["precio"], 0.01)) {
        Response::withError("❌ El precio debe ser un número válido (mayor a 0)", "../views/repuestos_view.php");
    }

    if (!Validator::isPositiveNumber($_POST["stock"], 0)) {
        Response::withError("❌ El stock debe ser un número válido (mayor o igual a 0)", "../views/repuestos_view.php");
    }

    try {
        $sql = "UPDATE repuestos SET nombre = ?, precio = ?, stock = ? WHERE id = ?";
        $parametros = [
            Validator::sanitizeText($_POST["nombre"]),
            (float) $_POST["precio"],
            (int) $_POST["stock"],
            (int) $_POST["id"],
        ];

        $model->executeNonQueryPrepared($sql, $parametros);
        Response::withSuccess("✅ Repuesto actualizado correctamente", "../views/repuestos_view.php");
    } catch (Exception $e) {
        Logger::error("Error al editar repuesto: " . $e->getMessage());
        Response::withError("❌ No se pudo actualizar el repuesto. Intenta de nuevo", "../views/repuestos_view.php");
    }
}

Response::withError("❌ Acción no reconocida", "../views/repuestos_view.php");
?>
