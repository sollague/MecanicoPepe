<?php
/**
 * ============================================================================
 * CLASE DATABASE - CONEXIÓN PDO CON SEGURIDAD MEJORADA
 * ============================================================================
 *
 * Esta clase reemplaza la antigua conexión mysqli de MecanicoPepe.php
 * Implementa PDO (PHP Data Objects) para:
 *
 * ✓ Prepared Statements (previene SQL Injection)
 * ✓ Mejores transacciones
 * ✓ Manejo de errores robusto
 * ✓ Compatible con múltiples bases de datos (MySQL, PostgreSQL, etc.)
 * ✓ Comentarios detallados en cada método
 *
 * UBICACIÓN: models/Database.php
 * REEMPLAZA: models/MecanicoPepe.php (la antigua conexión)
 * ============================================================================
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
     * Contraseña de MySQL (vacía en XAMPP por defecto)
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

/**
 * ============================================================================
 * CÓMO USAR ESTA CLASE EN TU PROYECTO
 * ============================================================================
 *
 * PASO 1:
 *
 *   require_once '../models/Database.php';
 *   $db = new Database();
 *   $servicios = $db->executeQuery("SELECT * FROM servicios");
 *
 * PASO 2: Consultas seguras
 *
 *   $sql = "SELECT * FROM usuarios WHERE usuario = ?";
 *   $resultado = $db->executeQuery($sql, [$usuario]);
 *
 * PASO 3: INSERT con ID
 *
 *   $db->executeNonQuery(
 *       "INSERT INTO repuestos (nombre, precio, stock) VALUES (?, ?, ?)",
 *       ['Aceite', 45.99, 10]
 *   );
 *   $id = $db->getLastInsertId();
 *
 * PASO 4: Transacciones
 *
 *   try {
 *       $db->beginTransaction();
 *       $db->commit();
 *   } catch (Exception $e) {
 *       $db->rollback();
 *   }
 *
 * ============================================================================
 */

?>
