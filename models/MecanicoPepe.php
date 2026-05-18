<?php

<<<<<<< HEAD
class MecanicoPepe
{
=======
<<<<<<< HEAD
class MecanicoPepe {

    private $conexion;

    public function __construct() {
        // Configuración de conexión
        $servidor = "localhost";
        $usuario = "root";
        $contrasena = "";
        $basedatos = "mecanicopepe";

        // Crear conexión
        $this->conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

        // Verificar conexión
        if ($this->conexion->connect_error) {
            die("❌ Error de conexión a la base de datos: " . $this->conexion->connect_error);
        }

        // Configurar charset UTF-8
        $this->conexion->set_charset("utf8mb4");
    }

    /**
     * Ejecutar consulta SELECT
     */
    public function executeQuery($sql, $parametros = []) {
        try {
            if (!empty($parametros)) {
                // Usar prepared statement
                $stmt = $this->conexion->prepare($sql);
                
                if (!$stmt) {
                    throw new Exception("Error en prepare: " . $this->conexion->error);
                }

                // Binding de parámetros
                $tipos = $this->detectarTipos($parametros);
                $stmt->bind_param($tipos, ...$parametros);

                if (!$stmt->execute()) {
                    throw new Exception("Error en execute: " . $stmt->error);
                }

                $resultado = $stmt->get_result();
                $datos = $resultado->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                return $datos;
            } else {
                // Consulta sin parámetros
                $resultado = $this->conexion->query($sql);

                if (!$resultado) {
                    throw new Exception("Error en query: " . $this->conexion->error);
                }

                return $resultado->fetch_all(MYSQLI_ASSOC);
            }
        } catch (Exception $e) {
            error_log("Error executeQuery: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Ejecutar INSERT, UPDATE o DELETE con prepared statements
     */
    public function executeNonQueryPrepared($sql, $parametros = []) {
        try {
            $stmt = $this->conexion->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error en prepare: " . $this->conexion->error);
            }

            if (!empty($parametros)) {
                $tipos = $this->detectarTipos($parametros);
                $stmt->bind_param($tipos, ...$parametros);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error en execute: " . $stmt->error);
            }

            $filas_afectadas = $stmt->affected_rows;
            $stmt->close();

            if ($filas_afectadas < 0) {
                throw new Exception("Error en la ejecución de la consulta");
            }

            return true;

        } catch (Exception $e) {
            error_log("Error executeNonQueryPrepared: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Detectar automáticamente el tipo de parámetro
     */
    private function detectarTipos($parametros) {
        $tipos = "";
        foreach ($parametros as $param) {
            if (is_int($param)) {
                $tipos .= "i";
            } elseif (is_float($param)) {
                $tipos .= "d";
            } elseif (is_string($param)) {
                $tipos .= "s";
            } else {
                $tipos .= "s";
            }
        }
        return $tipos;
    }

    /**
     * Ejecutar consulta sin prepared statements (OBSOLETO - NO USAR)
     */
    public function executeNonQuery($sql) {
        if ($this->conexion->query($sql) === TRUE) {
            return true;
        } else {
            throw new Exception("Error: " . $this->conexion->error);
        }
    }

    /**
     * Obtener el ID del último registro insertado
     */
    public function getLastInsertId() {
        return $this->conexion->insert_id;
    }

    /**
     * Cerrar la conexión
     */
    public function closeConnection() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    public function __destruct() {
        $this->closeConnection();
    }
}
?>
=======
class MecanicoPepe
{
    private $host = "localhost";
    private $db = "mecanicopepe";
    private $user = "root";
    private $pass = "";

>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    private $conexion;

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
    | CONSTRUCTOR
=======
    | CONEXIÓN
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    |--------------------------------------------------------------------------
    */

    public function __construct()
    {
<<<<<<< HEAD
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
=======
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
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    }

    /*
    |--------------------------------------------------------------------------
    | SELECT
    |--------------------------------------------------------------------------
    */

<<<<<<< HEAD
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
=======
    public function executeQuery($sql)
    {
        $resultado =
        $this->conexion->query($sql);

        $datos = [];

        while ($fila = $resultado->fetch_assoc()) {

            $datos[] = $fila;
        }

        return $datos;
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    }

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
    | INSERT UPDATE DELETE SIMPLE
=======
    | INSERT UPDATE DELETE
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    |--------------------------------------------------------------------------
    */

    public function executeNonQuery($sql)
    {
<<<<<<< HEAD
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
=======
        return $this->conexion->query($sql);
    }
}
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
