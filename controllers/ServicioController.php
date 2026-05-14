<?php
<<<<<<< HEAD

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
=======
session_start();
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
| VALIDAR SESIÓN
|--------------------------------------------------------------------------
*/

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
}

/*
|--------------------------------------------------------------------------
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
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
}

/*
|--------------------------------------------------------------------------
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
}

/*
|--------------------------------------------------------------------------
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
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
