<?php

/**
 * ============================================================================
 * USUARIO CONTROLLER
 * ============================================================================
 */

require_once __DIR__ . '/../config/app.php';

// Controlar visualización de errores desde config
if (defined('APP_DEBUG') && APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../models/TemporaryAuthProvider.php";
require_once "../models/Validator.php";
require_once "../models/Response.php";
require_once "../models/Logger.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    Response::redirect("../views/login_view.php");
}

$usuario = isset($_POST["usuario"]) ? Validator::sanitizeText($_POST["usuario"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

if (!Validator::required(["usuario", "password"], $_POST)) {
    Response::withError("❌ Usuario y contraseña requeridos", "../views/login_view.php");
}

if (!Validator::lengthBetween($usuario, 2, 50)) {
    Response::withError("❌ Usuario inválido", "../views/login_view.php");
}

if (!Validator::lengthBetween($password, 2, 100)) {
    Response::withError("❌ Contraseña inválida", "../views/login_view.php");
}

$authProvider = new TemporaryAuthProvider();

if ($authProvider->validateCredentials($usuario, $password)) {
    session_regenerate_id(true);
    $_SESSION["usuario"] = $usuario;
    $_SESSION["login_time"] = time();
    $_SESSION["ip"] = $_SERVER["REMOTE_ADDR"] ?? "";
    unset($_SESSION["error"]);
    Response::redirect("../views/dashboard_view.php");
}

Response::withError("❌ Usuario o contraseña incorrectos", "../views/login_view.php");

?>
