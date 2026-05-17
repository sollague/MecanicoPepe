<?php

/**
 * ============================================================================
 * USUARIO CONTROLLER
 * ============================================================================
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*
|--------------------------------------------------------------------------
| SESSION
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| IMPORTAR DATABASE
|--------------------------------------------------------------------------
*/

require_once "../models/Database.php";

/*
|--------------------------------------------------------------------------
| VALIDAR MÉTODO
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../views/login_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| DATOS FORMULARIO
|--------------------------------------------------------------------------
*/

$usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";

$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

/*
|--------------------------------------------------------------------------
| VALIDAR CAMPOS
|--------------------------------------------------------------------------
*/

if (empty($usuario) || empty($password)) {
    $_SESSION["error"] = "❌ Usuario y contraseña requeridos";

    header("Location: ../views/login_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| VALIDAR LONGITUD
|--------------------------------------------------------------------------
*/

if (strlen($usuario) < 2 || strlen($usuario) > 50) {
    $_SESSION["error"] = "❌ Usuario inválido";

    header("Location: ../views/login_view.php");
    exit();
}

if (strlen($password) < 2 || strlen($password) > 100) {
    $_SESSION["error"] = "❌ Contraseña inválida";

    header("Location: ../views/login_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| CONEXIÓN DATABASE
|--------------------------------------------------------------------------
*/

try {
    $db = new Database();
} catch (Exception $e) {
    $_SESSION["error"] = "❌ Error de conexión";

    header("Location: ../views/login_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| LOGIN TEMPORAL
|--------------------------------------------------------------------------
*/

$usuarioValido = "admin";

$passwordValida = "1234";

/*
|--------------------------------------------------------------------------
| VALIDAR CREDENCIALES
|--------------------------------------------------------------------------
*/

if ($usuario === $usuarioValido && $password === $passwordValida) {
    /*
    |--------------------------------------------------------------------------
    | LOGIN EXITOSO
    |--------------------------------------------------------------------------
    */

    session_regenerate_id(true);

    $_SESSION["usuario"] = $usuario;

    $_SESSION["login_time"] = time();

    $_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];

    unset($_SESSION["error"]);

    header("Location: ../views/dashboard_view.php");

    exit();
} else {
    /*
    |--------------------------------------------------------------------------
    | LOGIN FALLIDO
    |--------------------------------------------------------------------------
    */

    $_SESSION["error"] = "❌ Usuario o contraseña incorrectos";

    header("Location: ../views/login_view.php");

    exit();
}
