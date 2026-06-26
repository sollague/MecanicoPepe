<?php

/**
 * Class Database
 *
 * Wrapper simple para `PDO` que centraliza consultas y manejo de transacciones.
 * Todas las consultas deben usar los métodos de esta clase para aprovechar
 * prepared statements y manejo centralizado de excepciones.
 */
class Database
{
    // ========================================================================
    // PROPIEDADES PRIVADAS - Configuración de conexión
    // ========================================================================

    /**
     * @var PDO $conexion
     * Instancia de conexión PDO
     */
    private $conexion;

    /**
     * @var string $host
     * Host del servidor MySQL (localhost en desarrollo)
     */
    private $host = "localhost";

    /**
     * @var string $bd
     * Nombre de la base de datos
     */
    private $bd = "mecanicopepe";

    /**
     * @var string $usuario
     * Usuario de MySQL
     */
    private $usuario = "root";

    /**
     * @var string $password
     * Contraseña de MySQL
     */
    private $password = "";

    /**
     * @var string $dsn
     * Data Source Name - Cadena de conexión PDO
     * Formato: mysql:host=localhost;dbname=mecanicopepe;charset=utf8mb4
     */
    private $dsn;

    // ========================================================================
    // CONSTRUCTOR - Inicializa la conexión PDO
    // ========================================================================

    /**
     * Database constructor.
     * Inicializa la conexión PDO con los parámetros de la clase.
     * Lanza excepción si no puede conectarse.
     */
    public function __construct()
    {
        // Construir DSN con charset UTF-8 para caracteres especiales
        $this->dsn = "mysql:host={$this->host};dbname={$this->bd};charset=utf8mb4";

        try {
            $this->conexion = new PDO(
                $this->dsn,
                $this->usuario,
                $this->password,
                [
                    // Modo de error: lanzar excepciones en caso de error
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                    // Emulation desactivada: usar prepared statements nativos
                    PDO::ATTR_EMULATE_PREPARES => false,

                    // Retornar resultados como arrays asociativos por defecto
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                    // Timeout de conexión: 5 segundos máximo
                    PDO::ATTR_TIMEOUT => 5,
                ],
            );
        } catch (PDOException $e) {
            throw new Exception("Error de conexión con el servidor");
        }
    }

    // ========================================================================
    // MÉTODO: executeQuery() - Consultas SELECT (retorna resultados)
    // ========================================================================

    /**
     * Ejecuta una consulta SELECT y devuelve todos los resultados.
     *
     * @param string $sql
     * @param array $params
     * @return array
     * @throws PDOException
     */
    public function executeQuery($sql, $params = [])
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException(
                "Error en executeQuery: " . $e->getMessage(),
            );
        }
    }

    // ========================================================================
    // MÉTODO: executeQueryOne() - Consultas SELECT (retorna UN registro)
    // ========================================================================

    /**
     * Ejecuta una consulta SELECT y devuelve un único registro o null.
     *
     * @param string $sql
     * @param array $params
     * @return array|null
     * @throws PDOException
     */
    public function executeQueryOne($sql, $params = [])
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);

            $resultado = $stmt->fetch();
            return $resultado !== false ? $resultado : null;
        } catch (PDOException $e) {
            throw new PDOException(
                "Error en executeQueryOne: " . $e->getMessage(),
            );
        }
    }

    // ========================================================================
    // MÉTODO: executeNonQuery() - INSERT, UPDATE, DELETE
    // ========================================================================

    /**
     * Ejecuta INSERT/UPDATE/DELETE y devuelve el número de filas afectadas.
     *
     * @param string $sql
     * @param array $params
     * @return int
     * @throws PDOException
     */
    public function executeNonQuery($sql, $params = [])
    {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new PDOException(
                "Error en executeNonQuery: " . $e->getMessage(),
            );
        }
    }

    // ========================================================================
    // MÉTODO: getLastInsertId() - Obtiene el ID del último INSERT
    // ========================================================================

    /**
     * Retorna el último ID insertado por la conexión PDO.
     *
     * @return string
     */
    public function getLastInsertId()
    {
        return $this->conexion->lastInsertId();
    }

    // ========================================================================
    // MÉTODO: beginTransaction() - Inicia una transacción
    // ========================================================================

    /**
     * Inicia una transacción.
     */
    public function beginTransaction()
    {
        try {
            $this->conexion->beginTransaction();
        } catch (PDOException $e) {
            throw new PDOException(
                "Error al iniciar transacción: " . $e->getMessage(),
            );
        }
    }

    // ========================================================================
    // MÉTODO: commit() - Confirma una transacción
    // ========================================================================

    /**
     * Confirma la transacción actual.
     */
    public function commit()
    {
        try {
            $this->conexion->commit();
        } catch (PDOException $e) {
            throw new PDOException(
                "Error al confirmar transacción: " . $e->getMessage(),
            );
        }
    }

    // ========================================================================
    // MÉTODO: rollback() - Cancela una transacción
    // ========================================================================

    /**
     * Revierte la transacción actual.
     */
    public function rollback()
    {
        try {
            $this->conexion->rollBack();
        } catch (PDOException $e) {
            throw new PDOException(
                "Error al revertir transacción: " . $e->getMessage(),
            );
        }
    }

    // ========================================================================
    // MÉTODO: getConnection() - Retorna la conexión PDO directa
    // ========================================================================

    /**
     * Retorna la instancia PDO subyacente.
     *
     * @return PDO
     */
    public function getConnection()
    {
        return $this->conexion;
    }

    // ========================================================================
    // MÉTODO: close() - Cierra la conexión
    // ========================================================================

    /**
     * Cierra la conexión estableciendo la referencia a null.
     */
    public function close()
    {
        $this->conexion = null;
    }
}
?>
