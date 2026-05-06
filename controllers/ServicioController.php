<?php
session_start(); // Inicia la sesión para poder guardar datos y usarlos en otras páginas

// ================= VALIDACIÓN INICIAL =================

// Verifica que el usuario haya seleccionado al menos un servicio
if (empty($_POST['servicios'])) {
    echo "Debes seleccionar al menos un servicio";
    exit(); // Detiene la ejecución si no hay servicios
}

// ================= DATOS DEL CLIENTE =================

// Se obtienen los datos enviados desde el formulario
$cliente = $_POST['cliente'];
$cedula = $_POST['cedula'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$vehiculo = $_POST['vehiculo'];

// ================= VALIDACIONES =================

// Validación simple: la cédula debe tener exactamente 10 dígitos
if (strlen($cedula) != 10) {
    echo "La cédula debe tener 10 dígitos";
    exit(); // Detiene el proceso si no cumple
}

// ================= DATOS DEL SISTEMA =================

// Lista de servicios disponibles (simulando base de datos)
$servicios = [
    1 => ["nombre" => "Cambio de aceite", "precio" => 25],
    2 => ["nombre" => "Revisión general", "precio" => 40],
    3 => ["nombre" => "Alineación y balanceo", "precio" => 30],
    4 => ["nombre" => "Cambio de frenos", "precio" => 60]
];

// Lista de mecánicos disponibles (simulación)
$mecanicos = [
    ["nombre" => "Juan", "exp" => "5 años", "rating" => "4.5"],
    ["nombre" => "Carlos", "exp" => "8 años", "rating" => "4.8"],
    ["nombre" => "Pedro", "exp" => "3 años", "rating" => "4.2"]
];

// ================= SELECCIÓN DE MECÁNICO =================

// Se obtiene el índice del mecánico seleccionado en el formulario
$index = $_POST['mecanico'];

// Se obtiene el mecánico correspondiente del array
$mecanicoSeleccionado = $mecanicos[$index];

// ================= PROCESAMIENTO DE SERVICIOS =================

// Array donde se guardarán los servicios elegidos
$serviciosElegidos = [];

// Variable para acumular el total
$total = 0;

// Recorre los servicios seleccionados por el usuario
foreach ($_POST['servicios'] as $id) {

    // Agrega el servicio seleccionado al array
    $serviciosElegidos[] = $servicios[$id];

    // Suma el precio del servicio al total
    $total += $servicios[$id]['precio'];
}

// ================= GUARDAR EN SESIÓN =================

// Se guardan todos los datos para usarlos en la factura
$_SESSION['cliente'] = $cliente;
$_SESSION['cedula'] = $cedula;
$_SESSION['correo'] = $correo;
$_SESSION['telefono'] = $telefono;
$_SESSION['vehiculo'] = $vehiculo;
$_SESSION['mecanico'] = $mecanicoSeleccionado;
$_SESSION['servicios'] = $serviciosElegidos;
$_SESSION['total'] = $total;

// Se guarda la fecha actual
$_SESSION['fecha'] = date("Y-m-d");

// Se genera un ID de factura aleatorio
$_SESSION['factura_id'] = rand(1000, 9999);

// ================= REDIRECCIÓN =================

// Redirige a la vista de factura
header("Location: ../views/factura_view.php");