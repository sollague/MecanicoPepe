<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| VALIDAR MÉTODO POST
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    header("Location: ../views/servicios_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| IMPORTAR MODELO
|--------------------------------------------------------------------------
*/

require_once("../models/MecanicoPepe.php");

/*
|--------------------------------------------------------------------------
| CREAR OBJETO
|--------------------------------------------------------------------------
*/

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| VALIDAR SERVICIOS
|--------------------------------------------------------------------------
*/

if (empty($_POST['servicios'])) {

    header("Location: ../views/servicios_view.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| DATOS CLIENTE
|--------------------------------------------------------------------------
*/

$cliente = $_POST['cliente'];

$cedula = $_POST['cedula'];

$correo = $_POST['correo'];

$telefono = $_POST['telefono'];

$vehiculo = $_POST['vehiculo'];

$tipoMantenimiento =
$_POST['tipo_mantenimiento'];

$trabajos =
$_POST['trabajos'];

/*
|--------------------------------------------------------------------------
| VALIDACIÓN SIMPLE
|--------------------------------------------------------------------------
*/

if (strlen($cedula) != 10) {

    echo "La cédula debe tener 10 dígitos";
    exit();
}

/*
|--------------------------------------------------------------------------
| OBTENER MECÁNICO
|--------------------------------------------------------------------------
*/

$mecanicoID = $_POST['mecanico'];

$sqlMecanico = "
SELECT * FROM mecanicos
WHERE id = $mecanicoID
";

$resultadoMecanico =
$model->executeQuery($sqlMecanico);

if (count($resultadoMecanico) == 0) {

    echo "Mecánico no encontrado";
    exit();
}

$mecanicoSeleccionado =
$resultadoMecanico[0];

/*
|--------------------------------------------------------------------------
| PROCESAR SERVICIOS
|--------------------------------------------------------------------------
*/

$serviciosElegidos = [];

$total = 0;

foreach ($_POST['servicios'] as $idServicio) {

    $sqlServicio = "
    SELECT * FROM servicios
    WHERE id = $idServicio
    ";

    $resultadoServicio =
    $model->executeQuery($sqlServicio);

    if (count($resultadoServicio) > 0) {

        $servicio = $resultadoServicio[0];

        $serviciosElegidos[] = $servicio;

        $total += $servicio['precio'];
    }
}

/*
|--------------------------------------------------------------------------
| INSERTAR FACTURA
|--------------------------------------------------------------------------
*/

$fecha = date("Y-m-d");

$sqlFactura = "
INSERT INTO facturas
(
    cliente,
    cedula,
    correo,
    telefono,
    vehiculo,
    mecanico_id,
    tipo_mantenimiento,
    trabajos,
    total,
    fecha
)
VALUES
(
    '$cliente',
    '$cedula',
    '$correo',
    '$telefono',
    '$vehiculo',
    $mecanicoID,
    '$tipoMantenimiento',
    '$trabajos',
    $total,
    '$fecha'
)
";

$model->executeNonQuery($sqlFactura);

/*
|--------------------------------------------------------------------------
| OBTENER ID FACTURA
|--------------------------------------------------------------------------
*/

$facturaData = $model->executeQuery(
    "SELECT MAX(id) as id FROM facturas"
);

$facturaID = $facturaData[0]['id'];

/*
|--------------------------------------------------------------------------
| INSERTAR DETALLE FACTURA
|--------------------------------------------------------------------------
*/

foreach ($serviciosElegidos as $servicio) {

    $servicioID = $servicio['id'];

    $precio = $servicio['precio'];

    $sqlDetalle = "
    INSERT INTO detalle_factura
    (
        factura_id,
        servicio_id,
        precio
    )
    VALUES
    (
        $facturaID,
        $servicioID,
        $precio
    )
    ";

    $model->executeNonQuery($sqlDetalle);
}

/*
|--------------------------------------------------------------------------
| GUARDAR EN SESSION
|--------------------------------------------------------------------------
*/

$_SESSION['cliente'] = $cliente;

$_SESSION['cedula'] = $cedula;

$_SESSION['correo'] = $correo;

$_SESSION['telefono'] = $telefono;

$_SESSION['vehiculo'] = $vehiculo;

$_SESSION['tipo_mantenimiento'] =
$tipoMantenimiento;

$_SESSION['trabajos'] =
$trabajos;

$_SESSION['mecanico'] =
$mecanicoSeleccionado;

$_SESSION['servicios'] =
$serviciosElegidos;

$_SESSION['total'] = $total;

$_SESSION['fecha'] = $fecha;

$_SESSION['factura_id'] =
$facturaID;

/*
|--------------------------------------------------------------------------
| REDIRECCIÓN
|--------------------------------------------------------------------------
*/

header(
    "Location: ../views/factura_view.php"
);

exit();
?>