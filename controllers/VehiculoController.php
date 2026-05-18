<?php
session_start();
require_once "../models/MecanicoPepe.php";
$model = new MecanicoPepe();

// Función auxiliar para validar números
function esNumeroValido($valor, $minimo = 1)
{
    return is_numeric($valor) && (int) $valor >= $minimo;
}

// Función auxiliar para sanitizar texto
function sanitizarTexto($texto)
{
    return trim(strip_tags($texto));
}

// Función auxiliar para registrar errores
function registrarError($mensaje)
{
    error_log("[" . date("Y-m-d H:i:s") . "] Error: " . $mensaje);
}

/*
|--------------------------------------------------------------------------
| CREAR VEHÍCULO
|--------------------------------------------------------------------------
*/
if (isset($_POST["crear"])) {
    // Validar campos vacíos
    if (
        empty($_POST["marca"]) ||
        empty($_POST["modelo"]) ||
        empty($_POST["anio"]) ||
        empty($_POST["placa"]) ||
        empty($_POST["propietario"])
    ) {
        $_SESSION["error"] = "❌ Todos los campos son obligatorios";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    // Validar que el año sea un número válido
    if (!esNumeroValido($_POST["anio"], 1900)) {
        $_SESSION["error"] = "❌ El año debe ser un número válido";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    try {
        $sql = "INSERT INTO vehiculos (marca, modelo, anio, placa, propietario)
                VALUES (?, ?, ?, ?, ?)";
        $parametros = [
            sanitizarTexto($_POST["marca"]),
            sanitizarTexto($_POST["modelo"]),
            (int) $_POST["anio"],
            sanitizarTexto($_POST["placa"]),
            sanitizarTexto($_POST["propietario"]),
        ];

        // Verificar que executeNonQueryPrepared existe y es callable
        if (!method_exists($model, "executeNonQueryPrepared")) {
            throw new Exception("Método de base de datos no disponible");
        }

        $result = $model->executeNonQueryPrepared($sql, $parametros);

        if ($result === false) {
            throw new Exception(
                "No se pudo insertar el registro en la base de datos",
            );
        }

        $_SESSION["success"] = "✅ Vehículo registrado correctamente";
    } catch (PDOException $e) {
        // Error de base de datos (restricciones, conexión, etc)
        registrarError("Error PDO al crear vehículo: " . $e->getMessage());
        $_SESSION["error"] =
            "❌ Error en la base de datos. Por favor intenta de nuevo";
    } catch (Exception $e) {
        // Error general
        registrarError("Error general al crear vehículo: " . $e->getMessage());
        $_SESSION["error"] = "❌ No se pudo registrar el vehículo";
    }
    header("Location: ../views/vehiculos_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| EDITAR VEHÍCULO
|--------------------------------------------------------------------------
*/
if (isset($_POST["editar"])) {
    // Validar campos vacíos
    if (
        empty($_POST["id"]) ||
        empty($_POST["marca"]) ||
        empty($_POST["modelo"]) ||
        empty($_POST["anio"]) ||
        empty($_POST["placa"]) ||
        empty($_POST["propietario"])
    ) {
        $_SESSION["error"] = "❌ Todos los campos son obligatorios";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    // Validar que el ID sea válido
    if (!esNumeroValido($_POST["id"])) {
        $_SESSION["error"] = "❌ ID inválido";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    // Validar que el año sea un número válido
    if (!esNumeroValido($_POST["anio"], 1900)) {
        $_SESSION["error"] = "❌ El año debe ser un número válido";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    try {
        $sql = "UPDATE vehiculos
                SET marca = ?, modelo = ?, anio = ?, placa = ?, propietario = ?
                WHERE id = ?";
        $parametros = [
            sanitizarTexto($_POST["marca"]),
            sanitizarTexto($_POST["modelo"]),
            (int) $_POST["anio"],
            sanitizarTexto($_POST["placa"]),
            sanitizarTexto($_POST["propietario"]),
            (int) $_POST["id"],
        ];

        if (!method_exists($model, "executeNonQueryPrepared")) {
            throw new Exception("Método de base de datos no disponible");
        }

        $result = $model->executeNonQueryPrepared($sql, $parametros);

        if ($result === false) {
            throw new Exception("No se pudo actualizar el registro");
        }

        $_SESSION["success"] = "✅ Vehículo actualizado correctamente";
    } catch (PDOException $e) {
        registrarError("Error PDO al editar vehículo: " . $e->getMessage());
        $_SESSION["error"] =
            "❌ Error en la base de datos. Por favor intenta de nuevo";
    } catch (Exception $e) {
        registrarError("Error general al editar vehículo: " . $e->getMessage());
        $_SESSION["error"] = "❌ No se pudo actualizar el vehículo";
    }
    header("Location: ../views/vehiculos_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| ELIMINAR VEHÍCULO
|--------------------------------------------------------------------------
*/
if (isset($_GET["eliminar"])) {
    // Validar que el ID sea un número válido
    if (!esNumeroValido($_GET["eliminar"])) {
        $_SESSION["error"] = "❌ ID inválido";
        header("Location: ../views/vehiculos_view.php");
        exit();
    }

    $id = (int) $_GET["eliminar"];

    try {
        if (!method_exists($model, "executeNonQueryPrepared")) {
            throw new Exception("Método de base de datos no disponible");
        }

        $sql = "DELETE FROM vehiculos WHERE id = ?";
        $result = $model->executeNonQueryPrepared($sql, [$id]);

        if ($result === false) {
            throw new Exception("No se pudo eliminar el registro");
        }

        $_SESSION["success"] = "✅ Vehículo eliminado correctamente";
    } catch (PDOException $e) {
        registrarError("Error PDO al eliminar vehículo: " . $e->getMessage());
        $_SESSION["error"] =
            "❌ Error en la base de datos. Por favor intenta de nuevo";
    } catch (Exception $e) {
        registrarError(
            "Error general al eliminar vehículo: " . $e->getMessage(),
        );
        $_SESSION["error"] = "❌ No se pudo eliminar el vehículo";
    }
    header("Location: ../views/vehiculos_view.php");
    exit();
}

// Si llegamos aquí, algo no funcionó
$_SESSION["error"] = "❌ Acción no reconocida";
header("Location: ../views/vehiculos_view.php");
exit();
?>
