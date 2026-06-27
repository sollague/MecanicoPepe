<?php

session_start();

require_once __DIR__ . '/../models/Response.php';
require_once __DIR__ . '/../models/InvoicePdf.php';

if (!isset($_SESSION['factura_id'])) {
    Response::withError('❌ No hay factura para descargar. Genera una factura primero.', '../views/servicios_view.php');
}

$invoiceData = [
    'factura_id' => $_SESSION['factura_id'] ?? '',
    'fecha' => $_SESSION['fecha'] ?? '',
    'cliente' => $_SESSION['cliente'] ?? '',
    'cedula' => $_SESSION['cedula'] ?? '',
    'correo' => $_SESSION['correo'] ?? '',
    'telefono' => $_SESSION['telefono'] ?? '',
    'vehiculo' => $_SESSION['vehiculo'] ?? '',
    'tipo_mantenimiento' => $_SESSION['tipo_mantenimiento'] ?? '',
    'trabajos' => $_SESSION['trabajos'] ?? '',
    'mecanico' => $_SESSION['mecanico'] ?? null,
    'servicios' => $_SESSION['servicios'] ?? [],
    'subtotal' => $_SESSION['subtotal'] ?? 0,
    'iva' => $_SESSION['iva'] ?? 0,
    'total' => $_SESSION['total'] ?? 0,
];

$pdfContent = InvoicePdf::build($invoiceData);

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="factura_' . preg_replace('/[^0-9]/', '', $invoiceData['factura_id']) . '.pdf"');
header('Content-Length: ' . strlen($pdfContent));

echo $pdfContent;
exit();
