<?php
session_start();
require_once "../models/MecanicoPepe.php";

// Inicializar modelo con manejo de error crítico
try {
    $model = new MecanicoPepe();
} catch (Exception $e) {
    $_SESSION["error"] =
        "❌ No se puede conectar a la base de datos. Intenta más tarde";
    header("Location: ../views/repuestos_view.php");
    exit();
}

// Función auxiliar para validar números
function esNumeroValido($valor, $minimo = 0)
{
    return is_numeric($valor) && (float) $valor >= $minimo;
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
| CREAR REPUESTO
|--------------------------------------------------------------------------
*/
if (isset($_POST["crear"])) {
    // Validar campos vacíos
    if (
        empty($_POST["nombre"]) ||
        empty($_POST["precio"]) ||
        empty($_POST["stock"])
    ) {
        $_SESSION["error"] = "❌ Todos los campos son obligatorios";
        header("Location: ../views/repuestos_view.php");
        exit();
    }

    // Validar que precio sea número válido
    if (!esNumeroValido($_POST["precio"], 0.01)) {
        $_SESSION["error"] =
            "❌ El precio debe ser un número válido (mayor a 0)";
        header("Location: ../views/repuestos_view.php");
        exit();
    }

    // Validar que stock sea número válido
    if (!esNumeroValido($_POST["stock"], 0)) {
        $_SESSION["error"] =
            "❌ El stock debe ser un número válido (mayor o igual a 0)";
        header("Location: ../views/repuestos_view.php");
        exit();
    }

    try {
        // USAR PREPARED STATEMENTS para evitar SQL Injection
        $sql = "INSERT INTO repuestos (nombre, precio, stock)
                VALUES (?, ?, ?)";
        $parametros = [
            sanitizarTexto($_POST["nombre"]),
            (float) $_POST["precio"],
            (int) $_POST["stock"],
        ];

        $result = $model->executeNonQueryPrepared($sql, $parametros);

        if ($result === false) {
            throw new Exception("No se pudo insertar el repuesto");
        }

        $_SESSION["success"] = "✅ Repuesto registrado correctamente";
    } catch (Exception $e) {
        registrarError("Error al crear repuesto: " . $e->getMessage());
        $_SESSION["error"] =
            "❌ No se pudo registrar el repuesto. Intenta de nuevo";
    }
    header("Location: ../views/repuestos_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| ELIMINAR REPUESTO
|--------------------------------------------------------------------------
*/
if (isset($_GET["eliminar"])) {
    // Validar que el ID sea un número válido
    if (!is_numeric($_GET["eliminar"]) || (int) $_GET["eliminar"] <= 0) {
        $_SESSION["error"] = "❌ ID inválido";
        header("Location: ../views/repuestos_view.php");
        exit();
    }

    $id = (int) $_GET["eliminar"];

    try {
        // USAR PREPARED STATEMENTS para evitar SQL Injection
        $sql = "DELETE FROM repuestos WHERE id = ?";
        $result = $model->executeNonQueryPrepared($sql, [$id]);

        if ($result === false) {
            throw new Exception("No se pudo eliminar el repuesto");
        }

        $_SESSION["success"] = "✅ Repuesto eliminado correctamente";
    } catch (Exception $e) {
        registrarError("Error al eliminar repuesto: " . $e->getMessage());
        $_SESSION["error"] =
            "❌ No se pudo eliminar el repuesto. Intenta de nuevo";
    }
    header("Location: ../views/repuestos_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| ACTUALIZAR REPUESTO
|--------------------------------------------------------------------------
*/
if (isset($_POST["editar"])) {
    // Validar campos vacíos
    if (
        empty($_POST["id"]) ||
        empty($_POST["nombre"]) ||
        empty($_POST["precio"]) ||
        empty($_POST["stock"])
    ) {
        $_SESSION["error"] = "❌ Todos los campos son obligatorios";
        header("Location: ../views/repuestos_view.php");
        exit();
    }

    // Validar que el ID sea válido
    if (!is_numeric($_POST["id"]) || (int) $_POST["id"] <= 0) {
        $_SESSION["error"] = "❌ ID inválido";
        header("Location: ../views/repuestos_view.php");
        exit();
    }

    // Validar que precio sea número válido
    if (!esNumeroValido($_POST["precio"], 0.01)) {
        $_SESSION["error"] =
            "❌ El precio debe ser un número válido (mayor a 0)";
        header("Location: ../views/repuestos_view.php");
        exit();
    }

    // Validar que stock sea número válido
    if (!esNumeroValido($_POST["stock"], 0)) {
        $_SESSION["error"] =
            "❌ El stock debe ser un número válido (mayor o igual a 0)";
        header("Location: ../views/repuestos_view.php");
        exit();
    }

    try {
        // USAR PREPARED STATEMENTS para evitar SQL Injection
        $sql = "UPDATE repuestos
                SET nombre = ?, precio = ?, stock = ?
                WHERE id = ?";
        $parametros = [
            sanitizarTexto($_POST["nombre"]),
            (float) $_POST["precio"],
            (int) $_POST["stock"],
            (int) $_POST["id"],
        ];

        $result = $model->executeNonQueryPrepared($sql, $parametros);

        if ($result === false) {
            throw new Exception("No se pudo actualizar el repuesto");
        }

        $_SESSION["success"] = "✅ Repuesto actualizado correctamente";
    } catch (Exception $e) {
        registrarError("Error al editar repuesto: " . $e->getMessage());
        $_SESSION["error"] =
            "❌ No se pudo actualizar el repuesto. Intenta de nuevo";
    }
    header("Location: ../views/repuestos_view.php");
    exit();
}

// Si llegamos aquí, algo no funcionó
$_SESSION["error"] = "❌ Acción no reconocida";
header("Location: ../views/repuestos_view.php");
exit();
?>
