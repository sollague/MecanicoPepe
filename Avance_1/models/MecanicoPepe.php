<?php

class MecanicoPepe
{
    private $host = "localhost";
    private $db = "mecanicopepe";
    private $user = "root";
    private $pass = "";

    private $conexion;

    /*
    |--------------------------------------------------------------------------
    | CONEXIÓN
    |--------------------------------------------------------------------------
    */

    public function __construct()
    {
        $this->conexion = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if ($this->conexion->connect_error) {

            die(
                "Error de conexión: " .
                $this->conexion->connect_error
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SELECT
    |--------------------------------------------------------------------------
    */

    public function executeQuery($sql)
    {
        $resultado =
        $this->conexion->query($sql);

        $datos = [];

        while ($fila = $resultado->fetch_assoc()) {

            $datos[] = $fila;
        }

        return $datos;
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT UPDATE DELETE
    |--------------------------------------------------------------------------
    */

    public function executeNonQuery($sql)
    {
        return $this->conexion->query($sql);
    }
}