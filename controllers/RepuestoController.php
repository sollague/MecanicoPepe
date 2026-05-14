<?php

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

/*
|--------------------------------------------------------------------------
| CREAR REPUESTO
|--------------------------------------------------------------------------
*/

if (isset($_POST['crear'])) {

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "
    INSERT INTO repuestos
    (nombre, precio, stock)
    VALUES
    (
        '$nombre',
        '$precio',
        '$stock'
    )
    ";

    $model->executeNonQuery($sql);

    header("Location: ../views/repuestos_view.php");
}

/*
|--------------------------------------------------------------------------
| ELIMINAR REPUESTO
|--------------------------------------------------------------------------
*/

if (isset($_GET['eliminar'])) {

    $id = $_GET['eliminar'];

    $sql = "
    DELETE FROM repuestos
    WHERE id = $id
    ";

    $model->executeNonQuery($sql);

    header("Location: ../views/repuestos_view.php");
}

/*
|--------------------------------------------------------------------------
| ACTUALIZAR REPUESTO
|--------------------------------------------------------------------------
*/

if (isset($_POST['editar'])) {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "
    UPDATE repuestos
    SET
        nombre = '$nombre',
        precio = '$precio',
        stock = '$stock'
    WHERE id = $id
    ";

    $model->executeNonQuery($sql);

    header("Location: ../views/repuestos_view.php");
}