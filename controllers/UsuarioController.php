<?php
session_start();

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "
SELECT * FROM usuarios
WHERE usuario = '$usuario'
AND password = '$password'
";

$resultado = $model->executeQuery($sql);

if (count($resultado) > 0) {

    $_SESSION['usuario'] = $usuario;

    header(
        "Location: ../views/dashboard_view.php"
    );

} else {

    echo "Credenciales incorrectas";
}