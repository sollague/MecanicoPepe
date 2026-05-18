<?php
<<<<<<< HEAD

error_reporting(E_ALL);
ini_set("display_errors", 1);
=======
<<<<<<< HEAD
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
<<<<<<< HEAD

/*
|--------------------------------------------------------------------------
=======
=======
session_start();
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
| VALIDAR SESIÓN
|--------------------------------------------------------------------------
*/

<<<<<<< HEAD
if (!isset($_SESSION["usuario"])) {
    die("❌ Debe iniciar sesión");
}

/*
|--------------------------------------------------------------------------
| VALIDAR MÉTODO
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../views/servicios_view.php");
    exit();
=======
if (!isset($_SESSION['usuario'])) {

    die("❌ Debe iniciar sesión");
=======
| VALIDAR MÉTODO POST
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    header("Location: ../views/servicios_view.php");
    exit();
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
}

/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
=======
<<<<<<< HEAD
| IMPORTAR DATABASE
|--------------------------------------------------------------------------
*/

require_once '../models/Database.php';

/*
|--------------------------------------------------------------------------
| VALIDAR POST
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    die("❌ Método inválido");
=======
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
| IMPORTAR MODELO
|--------------------------------------------------------------------------
*/

<<<<<<< HEAD
require_once "../models/MecanicoPepe.php";
=======
require_once("../models/MecanicoPepe.php");

/*
|--------------------------------------------------------------------------
| CREAR OBJETO
|--------------------------------------------------------------------------
*/
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| VALIDAR SERVICIOS
|--------------------------------------------------------------------------
*/

<<<<<<< HEAD
if (empty($_POST["servicios"])) {
    die("❌ Debe seleccionar al menos un servicio");
=======
if (empty($_POST['servicios'])) {

    header("Location: ../views/servicios_view.php");
    exit();
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
}

/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
| DATOS
|--------------------------------------------------------------------------
*/

$cliente = trim($_POST["cliente"]);

$cedula = trim($_POST["cedula"]);

$correo = trim($_POST["correo"]);

$telefono = trim($_POST["telefono"]);

$vehiculo = trim($_POST["vehiculo"]);

$tipoMantenimiento = trim($_POST["tipo_mantenimiento"]);

$trabajos = trim($_POST["trabajos"]);

$mecanicoID = $_POST["mecanico"];

/*
|--------------------------------------------------------------------------
| VALIDACIONES
|--------------------------------------------------------------------------
*/

if (
    empty($cliente) ||
    empty($cedula) ||
    empty($correo) ||
    empty($telefono) ||
    empty($vehiculo)
) {
    die("❌ Complete todos los campos");
}

if (strlen($cedula) != 10) {
    die("❌ La cédula debe tener 10 dígitos");
=======
<<<<<<< HEAD
| FUNCIONES
|--------------------------------------------------------------------------
*/

function obtenerDato($clave, $defecto = '') {

    return isset($_POST[$clave])
        ? trim($_POST[$clave])
        : $defecto;
}

function validarCampo($valor, $nombre) {

    if (empty($valor)) {

        throw new Exception(
            "❌ Campo obligatorio: $nombre"
        );
    }
=======
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
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
}

/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
=======
<<<<<<< HEAD
| TRY PRINCIPAL
|--------------------------------------------------------------------------
*/

try {

    /*
    |--------------------------------------------------------------------------
    | DATOS
    |--------------------------------------------------------------------------
    */

    $cliente =
    obtenerDato('cliente');

    $cedula =
    obtenerDato('cedula');

    $correo =
    obtenerDato('correo');

    $telefono =
    obtenerDato('telefono');

    $vehiculo =
    obtenerDato('vehiculo');

    $tipoMantenimiento =
    obtenerDato('tipo_mantenimiento');

    $trabajos =
    obtenerDato('trabajos');

    $mecanicoID =
    obtenerDato('mecanico');

    $serviciosSeleccionados =
    isset($_POST['servicios'])
        ? $_POST['servicios']
        : [];

    /*
    |--------------------------------------------------------------------------
    | VALIDACIONES
    |--------------------------------------------------------------------------
    */

    validarCampo($cliente, 'Cliente');

    validarCampo($cedula, 'Cédula');

    validarCampo($correo, 'Correo');

    validarCampo($telefono, 'Teléfono');

    validarCampo($vehiculo, 'Vehículo');

    validarCampo(
        $tipoMantenimiento,
        'Tipo mantenimiento'
    );

    validarCampo(
        $mecanicoID,
        'Mecánico'
    );

    if (empty($serviciosSeleccionados)) {

        throw new Exception(
            "❌ Debe seleccionar servicios"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDAR NOMBRE
    |--------------------------------------------------------------------------
    */

    if (!preg_match(
        "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/",
        $cliente
    )) {

        throw new Exception(
            "❌ Nombre inválido"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BD
    |--------------------------------------------------------------------------
    */

    $db = new Database();

    /*
    |--------------------------------------------------------------------------
    | OBTENER MECÁNICO
    |--------------------------------------------------------------------------
    */

    $sqlMecanico = "
    SELECT *
    FROM mecanicos
    WHERE id = ?
    ";

    $mecanico =
    $db->executeQueryOne(
        $sqlMecanico,
        [$mecanicoID]
    );

    if (!$mecanico) {

        throw new Exception(
            "❌ Mecánico no encontrado"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SERVICIOS
    |--------------------------------------------------------------------------
    */

    $servicios = [];

    $totalFactura = 0;

    foreach (
        $serviciosSeleccionados
        as $servicioID
    ) {

        $sqlServicio = "
        SELECT *
        FROM servicios
        WHERE id = ?
        ";

        $servicio =
        $db->executeQueryOne(
            $sqlServicio,
            [$servicioID]
        );

        if (!$servicio) {

            throw new Exception(
                "❌ Servicio inválido"
            );
        }

        $servicios[] =
        $servicio;

        $totalFactura +=
        floatval($servicio['precio']);
    }

    /*
    |--------------------------------------------------------------------------
    | IVA
    |--------------------------------------------------------------------------
    */

    $subtotal =
    $totalFactura;

    $iva =
    $subtotal * 0.15;

    $totalConIVA =
    $subtotal + $iva;

    /*
    |--------------------------------------------------------------------------
    | TRANSACCIÓN
    |--------------------------------------------------------------------------
    */

    try {

        $db->beginTransaction();

        /*
        |--------------------------------------------------------------------------
        | INSERTAR FACTURA
        |--------------------------------------------------------------------------
        */

        $fechaActual =
        date('Y-m-d H:i:s');

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
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
        ";

        $db->executeNonQuery(
            $sqlFactura,
            [
                $cliente,
                $cedula,
                $correo,
                $telefono,
                $vehiculo,
                $mecanicoID,
                $tipoMantenimiento,
                $trabajos,
                $totalConIVA,
                $fechaActual
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ID FACTURA
        |--------------------------------------------------------------------------
        */

        $facturaID =
        $db->getLastInsertId();

        /*
        |--------------------------------------------------------------------------
        | DETALLE FACTURA
        |--------------------------------------------------------------------------
        */

        $sqlDetalle = "
        INSERT INTO detalle_factura
        (
            factura_id,
            servicio_id,
            precio
        )
        VALUES
        (
            ?, ?, ?
        )
        ";

        foreach ($servicios as $servicio) {

            $db->executeNonQuery(
                $sqlDetalle,
                [
                    $facturaID,
                    $servicio['id'],
                    $servicio['precio']
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | COMMIT
        |--------------------------------------------------------------------------
        */

        $db->commit();

        /*
        |--------------------------------------------------------------------------
        | SESSION
        |--------------------------------------------------------------------------
        */

        $_SESSION['cliente'] =
        $cliente;

        $_SESSION['cedula'] =
        $cedula;

        $_SESSION['correo'] =
        $correo;

        $_SESSION['telefono'] =
        $telefono;

        $_SESSION['vehiculo'] =
        $vehiculo;

        $_SESSION['tipo_mantenimiento'] =
        $tipoMantenimiento;

        $_SESSION['trabajos'] =
        $trabajos;

        $_SESSION['mecanico'] =
        $mecanico;

        $_SESSION['servicios'] =
        $servicios;

        $_SESSION['subtotal'] =
        $subtotal;

        $_SESSION['iva'] =
        $iva;

        $_SESSION['total'] =
        $totalConIVA;

        $_SESSION['fecha'] =
        $fechaActual;

        $_SESSION['factura_id'] =
        $facturaID;

        /*
        |--------------------------------------------------------------------------
        | REDIRECCIÓN
        |--------------------------------------------------------------------------
        */

        header(
            'Location: ../views/factura_view.php'
        );

        exit();

    } catch (Exception $e) {

        $db->rollback();

        die(
            "❌ ERROR BD: "
            . $e->getMessage()
        );
    }

} catch (Exception $e) {

    die(
        "❌ ERROR: "
        . $e->getMessage()
    );
}
=======
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
| OBTENER MECÁNICO
|--------------------------------------------------------------------------
*/

<<<<<<< HEAD
=======
$mecanicoID = $_POST['mecanico'];

>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
$sqlMecanico = "
SELECT * FROM mecanicos
WHERE id = $mecanicoID
";

<<<<<<< HEAD
$resultadoMecanico = $model->executeQuery($sqlMecanico);

if (count($resultadoMecanico) == 0) {
    die("❌ Mecánico no encontrado");
}

$mecanicoSeleccionado = $resultadoMecanico[0];
=======
$resultadoMecanico =
$model->executeQuery($sqlMecanico);

if (count($resultadoMecanico) == 0) {

    echo "Mecánico no encontrado";
    exit();
}

$mecanicoSeleccionado =
$resultadoMecanico[0];
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

/*
|--------------------------------------------------------------------------
| PROCESAR SERVICIOS
|--------------------------------------------------------------------------
*/

$serviciosElegidos = [];

$total = 0;

<<<<<<< HEAD
foreach ($_POST["servicios"] as $idServicio) {
=======
foreach ($_POST['servicios'] as $idServicio) {

>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    $sqlServicio = "
    SELECT * FROM servicios
    WHERE id = $idServicio
    ";

<<<<<<< HEAD
    $resultadoServicio = $model->executeQuery($sqlServicio);

    if (count($resultadoServicio) > 0) {
=======
    $resultadoServicio =
    $model->executeQuery($sqlServicio);

    if (count($resultadoServicio) > 0) {

>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
        $servicio = $resultadoServicio[0];

        $serviciosElegidos[] = $servicio;

<<<<<<< HEAD
        $total += $servicio["precio"];
=======
        $total += $servicio['precio'];
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
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

<<<<<<< HEAD
$facturaData = $model->executeQuery("SELECT MAX(id) as id FROM facturas");

$facturaID = $facturaData[0]["id"];
=======
$facturaData = $model->executeQuery(
    "SELECT MAX(id) as id FROM facturas"
);

$facturaID = $facturaData[0]['id'];
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

/*
|--------------------------------------------------------------------------
| INSERTAR DETALLE FACTURA
|--------------------------------------------------------------------------
*/

foreach ($serviciosElegidos as $servicio) {
<<<<<<< HEAD
    $servicioID = $servicio["id"];

    $precio = $servicio["precio"];
=======

    $servicioID = $servicio['id'];

    $precio = $servicio['precio'];
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

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
<<<<<<< HEAD
| SESSION
|--------------------------------------------------------------------------
*/

$_SESSION["cliente"] = $cliente;

$_SESSION["cedula"] = $cedula;

$_SESSION["correo"] = $correo;

$_SESSION["telefono"] = $telefono;

$_SESSION["vehiculo"] = $vehiculo;

$_SESSION["tipo_mantenimiento"] = $tipoMantenimiento;

$_SESSION["trabajos"] = $trabajos;

$_SESSION["mecanico"] = $mecanicoSeleccionado;

$_SESSION["servicios"] = $serviciosElegidos;

$_SESSION["total"] = $total;

$_SESSION["fecha"] = $fecha;

$_SESSION["factura_id"] = $facturaID;
=======
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
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf

/*
|--------------------------------------------------------------------------
| REDIRECCIÓN
|--------------------------------------------------------------------------
*/

<<<<<<< HEAD
header("Location: ../views/factura_view.php");

exit();
=======
header(
    "Location: ../views/factura_view.php"
);

exit();
?>
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
