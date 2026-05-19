<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "mecanicopepe";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    die("Error de conexión");
}