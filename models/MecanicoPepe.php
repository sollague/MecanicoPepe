<?php

class MecanicoPepe
{
    private $conexion;
    private $maxReintentos = 3; // Reintentos en caso de fallo de conexión
    private $tiempoEspera = 1; // Segundos entre reintentos

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

                // Conexión exitosa, salir del bucle
                $this->conexion->set_charset("utf8mb4");
                error_log("[MecanicoPepe] Conexión establecida correctamente");
                return;
            } catch (Exception $e) {
                error_log(
                    "[MecanicoPepe] Intento $intento fallido: " .
                        $e->getMessage(),
                );

                // Si es el último intento, lanzar excepción
                if ($intento === $this->maxReintentos) {
                    throw new Exception(
                        "No se pudo conectar a la base de datos después de $this->maxReintentos intentos",
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
            // Verificar que la conexión esté activa
            $this->verificarConexion();

            if (!empty($parametros)) {
                $stmt = $this->conexion->prepare($sql);

                if (!$stmt) {
                    throw new Exception(
                        "Error prepare: " . $this->conexion->error,
                    );
                }

                $tipos = $this->detectarTipos($parametros);

                // Validar que los tipos coincidan con los parámetros
                if (strlen($tipos) !== count($parametros)) {
                    throw new Exception("Cantidad de parámetros no coincide");
                }

                $stmt->bind_param($tipos, ...$parametros);

                if (!$stmt->execute()) {
                    throw new Exception("Error execute: " . $stmt->error);
                }

                $resultado = $stmt->get_result();

                // Verificar si hay resultados
                if (!$resultado) {
                    throw new Exception(
                        "Error al obtener resultados: " . $stmt->error,
                    );
                }

                $datos = $resultado->fetch_all(MYSQLI_ASSOC);

                $stmt->close();

                return $datos ?: []; // Retornar array vacío si no hay datos
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
            error_log("[MecanicoPepe] Error executeQuery: " . $e->getMessage());
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

            $resultado = $this->conexion->query($sql);

            if ($resultado === false) {
                throw new Exception(
                    "Error en query: " . $this->conexion->error,
                );
            }

            return $resultado;
        } catch (Exception $e) {
            error_log(
                "[MecanicoPepe] Error executeNonQuery: " . $e->getMessage(),
            );
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

                // Validar cantidad de parámetros
                if (strlen($tipos) !== count($parametros)) {
                    throw new Exception("Cantidad de parámetros no coincide");
                }

                $stmt->bind_param($tipos, ...$parametros);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error execute: " . $stmt->error);
            }

            // Guardar filas afectadas antes de cerrar
            $filasAfectadas = $stmt->affected_rows;

            $stmt->close();

            // Retornar cantidad de filas afectadas (0 o más es éxito, -1 es error)
            return $filasAfectadas >= 0 ? true : false;
        } catch (Exception $e) {
            error_log(
                "[MecanicoPepe] Error executeNonQueryPrepared: " .
                    $e->getMessage(),
            );
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
        try {
            return $this->conexion->insert_id;
        } catch (Exception $e) {
            error_log(
                "[MecanicoPepe] Error getLastInsertId: " . $e->getMessage(),
            );
            return 0;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CERRAR CONEXIÓN
    |--------------------------------------------------------------------------
    */

    public function closeConnection()
    {
        try {
            if ($this->conexion) {
                $this->conexion->close();
            }
        } catch (Exception $e) {
            error_log(
                "[MecanicoPepe] Error al cerrar conexión: " . $e->getMessage(),
            );
        }
    }

    public function __destruct()
    {
        $this->closeConnection();
    }
}

?>
