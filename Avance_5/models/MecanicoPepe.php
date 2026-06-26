<?php

class MecanicoPepe
{
    private $conexion;
    private $maxReintentos = 3;
    private $tiempoEspera = 1;

    public function __construct()
    {
        $this->conectarConReintentos();
    }

    /*
    |--------------------------------------------------------------------------
    | CONECTAR CON REINTENTOS
    |--------------------------------------------------------------------------
    */

    private function conectarConReintentos()
    {
        $servidor = "localhost";
        $usuario = "root";
        $contrasena = "";
        $basedatos = "mecanicopepe";

        for ($intento = 1; $intento <= $this->maxReintentos; $intento++) {
            try {
                $this->conexion = new mysqli(
                    $servidor,
                    $usuario,
                    $contrasena,
                    $basedatos,
                );

                if ($this->conexion->connect_error) {
                    throw new Exception($this->conexion->connect_error);
                }

                // Conexión exitosa
                $this->conexion->set_charset("utf8mb4");
                error_log(
                    "[MecanicoPepe] Conexión establecida (intento $intento)",
                );
                return;
            } catch (Exception $e) {
                error_log(
                    "[MecanicoPepe] Intento $intento fallido: " .
                        $e->getMessage(),
                );

                // Si es el último intento, lanzar excepción
                if ($intento === $this->maxReintentos) {
                    throw new Exception(
                        "No se pudo conectar a la BD después de $this->maxReintentos intentos",
                    );
                }

                // Esperar antes del próximo intento
                sleep($this->tiempoEspera);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFICAR CONEXIÓN
    |--------------------------------------------------------------------------
    */

    private function verificarConexion()
    {
        if (!$this->conexion || !$this->conexion->ping()) {
            error_log("[MecanicoPepe] Conexión perdida, reconectando...");
            $this->conectarConReintentos();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SELECT
    |--------------------------------------------------------------------------
    */

    public function executeQuery($sql, $parametros = [])
    {
        try {
            // Verificar conexión antes de ejecutar
            $this->verificarConexion();

            if (!empty($parametros)) {
                $stmt = $this->conexion->prepare($sql);

                if (!$stmt) {
                    throw new Exception(
                        "Error prepare: " . $this->conexion->error,
                    );
                }

                $tipos = $this->detectarTipos($parametros);

                // Validar que haya mismo número de tipos y parámetros
                if (strlen($tipos) !== count($parametros)) {
                    throw new Exception("Cantidad de parámetros no coincide");
                }

                $stmt->bind_param($tipos, ...$parametros);

                if (!$stmt->execute()) {
                    throw new Exception("Error execute: " . $stmt->error);
                }

                $resultado = $stmt->get_result();

                // Si $resultado es falso, devolver array vacío
                if (!$resultado) {
                    $stmt->close();
                    return [];
                }

                $datos = $resultado->fetch_all(MYSQLI_ASSOC);

                $stmt->close();

                return $datos ?: []; // Devolver array vacío si no hay datos
            } else {
                $resultado = $this->conexion->query($sql);

                if (!$resultado) {
                    throw new Exception(
                        "Error query: " . $this->conexion->error,
                    );
                }

                return $resultado->fetch_all(MYSQLI_ASSOC) ?: [];
            }
        } catch (Exception $e) {
            error_log("Error executeQuery: " . $e->getMessage());
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | INSERT UPDATE DELETE
    |--------------------------------------------------------------------------
    */

    public function executeNonQuery($sql)
    {
        try {
            $this->verificarConexion();
            return $this->conexion->query($sql);
        } catch (Exception $e) {
            error_log("Error executeNonQuery: " . $e->getMessage());
            throw $e;
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
            // Verificar conexión antes de ejecutar
            $this->verificarConexion();

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

    public function beginTransaction()
    {
        if (!$this->conexion->begin_transaction()) {
            throw new Exception("No se pudo iniciar la transacción: " . $this->conexion->error);
        }
    }

    public function commit()
    {
        if (!$this->conexion->commit()) {
            throw new Exception("No se pudo confirmar la transacción: " . $this->conexion->error);
        }
    }

    public function rollback()
    {
        if (!$this->conexion->rollback()) {
            throw new Exception("No se pudo revertir la transacción: " . $this->conexion->error);
        }
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

    public function __destruct()
    {
        $this->closeConnection();
    }
}

?>
