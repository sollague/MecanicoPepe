<?php

class MecanicoPepe
{
    private $conexion;

    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct()
    {
        $servidor = "localhost";

        $usuario = "root";

        $contrasena = "";

        $basedatos = "mecanicopepe";

        /*
        |--------------------------------------------------------------------------
        | CONEXIÓN
        |--------------------------------------------------------------------------
        */

        $this->conexion = new mysqli(
            $servidor,
            $usuario,
            $contrasena,
            $basedatos,
        );

        /*
        |--------------------------------------------------------------------------
        | VALIDAR CONEXIÓN
        |--------------------------------------------------------------------------
        */

        if ($this->conexion->connect_error) {
            die("❌ Error de conexión: " . $this->conexion->connect_error);
        }

        /*
        |--------------------------------------------------------------------------
        | UTF8
        |--------------------------------------------------------------------------
        */

        $this->conexion->set_charset("utf8mb4");
    }

    /*
    |--------------------------------------------------------------------------
    | SELECT
    |--------------------------------------------------------------------------
    */

    public function executeQuery($sql, $parametros = [])
    {
        try {
            /*
            |--------------------------------------------------------------------------
            | PREPARED STATEMENTS
            |--------------------------------------------------------------------------
            */

            if (!empty($parametros)) {
                $stmt = $this->conexion->prepare($sql);

                if (!$stmt) {
                    throw new Exception(
                        "Error prepare: " . $this->conexion->error,
                    );
                }

                $tipos = $this->detectarTipos($parametros);

                $stmt->bind_param($tipos, ...$parametros);

                if (!$stmt->execute()) {
                    throw new Exception("Error execute: " . $stmt->error);
                }

                $resultado = $stmt->get_result();

                $datos = $resultado->fetch_all(MYSQLI_ASSOC);

                $stmt->close();

                return $datos;
            } else {
                /*
                |--------------------------------------------------------------------------
                | QUERY SIMPLE
                |--------------------------------------------------------------------------
                */

                $resultado = $this->conexion->query($sql);

                if (!$resultado) {
                    throw new Exception(
                        "Error query: " . $this->conexion->error,
                    );
                }

                return $resultado->fetch_all(MYSQLI_ASSOC);
            }
        } catch (Exception $e) {
            error_log("Error executeQuery: " . $e->getMessage());

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT UPDATE DELETE SIMPLE
    |--------------------------------------------------------------------------
    */

    public function executeNonQuery($sql)
    {
        if ($this->conexion->query($sql) === true) {
            return true;
        } else {
            throw new Exception("Error: " . $this->conexion->error);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT UPDATE DELETE PREPARED
    |--------------------------------------------------------------------------
    */

    public function executeNonQueryPrepared($sql, $parametros = [])
    {
        try {
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error prepare: " . $this->conexion->error);
            }

            if (!empty($parametros)) {
                $tipos = $this->detectarTipos($parametros);

                $stmt->bind_param($tipos, ...$parametros);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error execute: " . $stmt->error);
            }

            $stmt->close();

            return true;
        } catch (Exception $e) {
            error_log("Error executeNonQueryPrepared: " . $e->getMessage());

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DETECTAR TIPOS
    |--------------------------------------------------------------------------
    */

    private function detectarTipos($parametros)
    {
        $tipos = "";

        foreach ($parametros as $param) {
            if (is_int($param)) {
                $tipos .= "i";
            } elseif (is_float($param)) {
                $tipos .= "d";
            } else {
                $tipos .= "s";
            }
        }

        return $tipos;
    }

    /*
    |--------------------------------------------------------------------------
    | ÚLTIMO ID
    |--------------------------------------------------------------------------
    */

    public function getLastInsertId()
    {
        return $this->conexion->insert_id;
    }

    /*
    |--------------------------------------------------------------------------
    | CERRAR CONEXIÓN
    |--------------------------------------------------------------------------
    */

    public function closeConnection()
    {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DESTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __destruct()
    {
        $this->closeConnection();
    }
}

?>
