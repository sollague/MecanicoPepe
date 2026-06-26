<?php

// Configuración básica de conexión MySQL usada por algunas partes del
// proyecto. En aplicaciones más grandes esta información debería ir en
// variables de entorno o en un archivo seguro fuera del repositorio.
$host = "localhost";
$user = "root";
$password = "";
$database = "mecanicopepe";

// Crear conexión con MySQL usando mysqli
$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

// Validar que la conexión fue exitosa
if (!$conn) {
    die("Error de conexión");
}