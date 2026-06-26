<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../models/MecanicoPepe.php";
require_once "../models/Validator.php";
require_once "../models/Response.php";
require_once "../models/Logger.php";
require_once "../models/FacturaService.php";

if (!isset($_SESSION["usuario"])) {
    Response::withError("❌ Debe iniciar sesión", "../views/login_view.php");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    Response::redirect("../views/servicios_view.php");
}

if (empty($_POST["servicios"]) || !is_array($_POST["servicios"])) {
    Response::withError("❌ Seleccione al menos un servicio", "../views/servicios_view.php");
}

$cliente = Validator::sanitizeText($_POST["cliente"] ?? "");
$cedula = Validator::sanitizeText($_POST["cedula"] ?? "");
$correo = Validator::sanitizeText($_POST["correo"] ?? "");
$telefono = Validator::sanitizeText($_POST["telefono"] ?? "");
$vehiculo = Validator::sanitizeText($_POST["vehiculo"] ?? "");
$tipoMantenimiento = Validator::sanitizeText($_POST["tipo_mantenimiento"] ?? "");
$trabajos = Validator::sanitizeText($_POST["trabajos"] ?? "");
$mecanicoID = $_POST["mecanico"] ?? "";

if (!Validator::required(["cliente", "cedula", "correo", "telefono", "vehiculo", "mecanico"], $_POST)) {
    Response::withError("❌ Complete todos los campos", "../views/servicios_view.php");
}

if (!Validator::validateCedula($cedula)) {
    Response::withError("❌ La cédula debe tener 10 dígitos", "../views/servicios_view.php");
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    Response::withError("❌ Correo inválido", "../views/servicios_view.php");
}

if (!Validator::isValidId($mecanicoID)) {
    Response::withError("❌ Mecánico inválido", "../views/servicios_view.php");
}

try {
    $db = new MecanicoPepe();
    $facturaService = new FacturaService($db);
} catch (Exception $e) {
    Logger::error("Error al inicializar modelo de servicios: " . $e->getMessage());
    Response::withError("❌ No se puede conectar a la base de datos. Intenta más tarde", "../views/servicios_view.php");
}

$mecanicoSeleccionado = $facturaService->findMecanico((int) $mecanicoID);
if (!$mecanicoSeleccionado) {
    Response::withError("❌ Mecánico no encontrado", "../views/servicios_view.php");
}

$serviciosElegidos = $facturaService->findServicios($_POST["servicios"]);
if (empty($serviciosElegidos)) {
    Response::withError("❌ No se encontraron servicios válidos", "../views/servicios_view.php");
}

try {
    $facturaId = $facturaService->createFactura(
        [
            'cliente' => $cliente,
            'cedula' => $cedula,
            'correo' => $correo,
            'telefono' => $telefono,
            'vehiculo' => $vehiculo,
        ],
        (int) $mecanicoID,
        $serviciosElegidos,
        $tipoMantenimiento,
        $trabajos,
        date("Y-m-d"),
        $_SESSION['usuario'] ?? 'system'
    );
} catch (Exception $e) {
    Response::withError("❌ No se pudo procesar la factura. Intenta de nuevo", "../views/servicios_view.php");
}

$_SESSION["cliente"] = $cliente;
$_SESSION["cedula"] = $cedula;
$_SESSION["correo"] = $correo;
$_SESSION["telefono"] = $telefono;
$_SESSION["vehiculo"] = $vehiculo;
$_SESSION["tipo_mantenimiento"] = $tipoMantenimiento;
$_SESSION["trabajos"] = $trabajos;
$_SESSION["mecanico"] = $mecanicoSeleccionado;
$_SESSION["servicios"] = $serviciosElegidos;
$_SESSION["subtotal"] = array_sum(array_map(fn($s) => (float) $s['precio'], $serviciosElegidos));
$_SESSION["iva"] = round($_SESSION["subtotal"] * 0.15, 2);
$_SESSION["total"] = round($_SESSION["subtotal"] + $_SESSION["iva"], 2);
$_SESSION["fecha"] = date("Y-m-d");
$_SESSION["factura_id"] = $facturaId;

Response::redirect("../views/factura_view.php");
