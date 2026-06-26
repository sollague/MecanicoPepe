<?php

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

    public function getLastInsertId()
    {
        return $this->conexion->lastInsertId();
    }

    // ========================================================================
    // MÉTODO: beginTransaction() - Inicia una transacción
    // ========================================================================

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

    public function getConnection()
    {
        return $this->conexion;
    }

    // ========================================================================
    // MÉTODO: close() - Cierra la conexión
    // ========================================================================

    public function close()
    {
        $this->conexion = null;
    }
}
?>
