<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| VALIDAR SESIÓN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['usuario'])) {

    die("❌ Debe iniciar sesión");
}

/*
|--------------------------------------------------------------------------
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
}

/*
|--------------------------------------------------------------------------
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
}

/*
|--------------------------------------------------------------------------
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