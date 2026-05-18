<?php
/**
 * ============================================================================
 * CLASE DATABASE - CONEXIÓN PDO CON SEGURIDAD MEJORADA
 * ============================================================================
<<<<<<< HEAD
 *
 * Esta clase reemplaza la antigua conexión mysqli de MecanicoPepe.php
 * Implementa PDO (PHP Data Objects) para:
 *
=======
 * 
 * Esta clase reemplaza la antigua conexión mysqli de MecanicoPepe.php
 * Implementa PDO (PHP Data Objects) para:
 * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
 * ✓ Prepared Statements (previene SQL Injection)
 * ✓ Mejores transacciones
 * ✓ Manejo de errores robusto
 * ✓ Compatible con múltiples bases de datos (MySQL, PostgreSQL, etc.)
 * ✓ Comentarios detallados en cada método
<<<<<<< HEAD
 *
=======
 * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
 * UBICACIÓN: models/Database.php
 * REEMPLAZA: models/MecanicoPepe.php (la antigua conexión)
 * ============================================================================
 */

class Database {
<<<<<<< HEAD

    // ========================================================================
    // PROPIEDADES PRIVADAS - Configuración de conexión
    // ========================================================================

=======
    
    // ========================================================================
    // PROPIEDADES PRIVADAS - Configuración de conexión
    // ========================================================================
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * @var PDO $conexion
     * Instancia de conexión PDO
     */
    private $conexion;
<<<<<<< HEAD

=======
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * @var string $host
     * Host del servidor MySQL (localhost en desarrollo)
     */
    private $host = 'localhost';
<<<<<<< HEAD

=======
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * @var string $bd
     * Nombre de la base de datos
     */
    private $bd = 'mecanicopepe';
<<<<<<< HEAD

=======
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * @var string $usuario
     * Usuario de MySQL
     */
    private $usuario = 'root';
<<<<<<< HEAD

=======
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * @var string $password
     * Contraseña de MySQL (vacía en XAMPP por defecto)
     */
    private $password = '';
<<<<<<< HEAD

=======
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * @var string $dsn
     * Data Source Name - Cadena de conexión PDO
     * Formato: mysql:host=localhost;dbname=mecanicopepe;charset=utf8mb4
     */
    private $dsn;
<<<<<<< HEAD

    // ========================================================================
    // CONSTRUCTOR - Inicializa la conexión PDO
    // ========================================================================

    /**
     * Constructor
     *
     * Se ejecuta automáticamente al instanciar la clase:
     * $db = new Database();
     *
=======
    
    // ========================================================================
    // CONSTRUCTOR - Inicializa la conexión PDO
    // ========================================================================
    
    /**
     * Constructor
     * 
     * Se ejecuta automáticamente al instanciar la clase:
     * $db = new Database();
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * Tareas:
     * 1. Construye el DSN (cadena de conexión)
     * 2. Intenta conectar con try/catch
     * 3. Si falla, detiene la ejecución con mensaje de error
     */
    public function __construct() {
<<<<<<< HEAD

        // Construir DSN con charset UTF-8 para caracteres especiales
        $this->dsn = "mysql:host={$this->host};dbname={$this->bd};charset=utf8mb4";

=======
        
        // Construir DSN con charset UTF-8 para caracteres especiales
        $this->dsn = "mysql:host={$this->host};dbname={$this->bd};charset=utf8mb4";
        
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
        try {
            $this->conexion = new PDO(
                $this->dsn,
                $this->usuario,
                $this->password,
                [
                    // Modo de error: lanzar excepciones en caso de error
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
<<<<<<< HEAD

                    // Emulation desactivada: usar prepared statements nativos
                    PDO::ATTR_EMULATE_PREPARES => false,

                    // Retornar resultados como arrays asociativos por defecto
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

=======
                    
                    // Emulation desactivada: usar prepared statements nativos
                    PDO::ATTR_EMULATE_PREPARES => false,
                    
                    // Retornar resultados como arrays asociativos por defecto
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
                    // Timeout de conexión: 5 segundos máximo
                    PDO::ATTR_TIMEOUT => 5
                ]
            );
<<<<<<< HEAD

            // Conexión exitosa - puedes agregar log aquí si es necesario
            // error_log("Conexión PDO exitosa a " . $this->bd);

=======
            
            // Conexión exitosa - puedes agregar log aquí si es necesario
            // error_log("Conexión PDO exitosa a " . $this->bd);
            
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
        } catch (PDOException $e) {
            /**
             * Si la conexión falla:
             * - Se captura la excepción PDOException
             * - Se muestra mensaje de error
             * - Se detiene la ejecución
<<<<<<< HEAD
             *
=======
             * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
             * En producción, NO mostrar detalles del error al usuario
             * Usar error_log() en su lugar
             */
            throw new Exception(
                "Error de conexión con el servidor"
            );
        }
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: executeQuery() - Consultas SELECT (retorna resultados)
    // ========================================================================

    /**
     * Ejecuta consultas SELECT y retorna los resultados
     *
     * USO (ejemplo):
     * $db = new Database();
     * $servicios = $db->executeQuery("SELECT * FROM servicios");
     *
=======
    
    // ========================================================================
    // MÉTODO: executeQuery() - Consultas SELECT (retorna resultados)
    // ========================================================================
    
    /**
     * Ejecuta consultas SELECT y retorna los resultados
     * 
     * USO (ejemplo):
     * $db = new Database();
     * $servicios = $db->executeQuery("SELECT * FROM servicios");
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * O CON PARÁMETROS (seguro contra SQL Injection):
     * $usuario = "admin";
     * $usuarios = $db->executeQuery(
     *     "SELECT * FROM usuarios WHERE usuario = ?",
     *     [$usuario]
     * );
<<<<<<< HEAD
     *
=======
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * @param string $sql Consulta SQL con placeholders ? para parámetros
     * @param array $params Array opcional de parámetros para prepared statement
     * @return array Array de resultados (cada fila es un array asociativo)
     * @throws PDOException Si hay error en la consulta
     */
    public function executeQuery($sql, $params = []) {
<<<<<<< HEAD

=======
        
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
        try {
            /**
             * Paso 1: Preparar la consulta
             * prepare() crea un statement preparado
             * Los ? serán reemplazados de forma segura por los valores reales
             */
            $stmt = $this->conexion->prepare($sql);
<<<<<<< HEAD

=======
            
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
            /**
             * Paso 2: Ejecutar con parámetros
             * execute() vincula los parámetros y ejecuta
             * Esto PREVIENE SQL Injection automáticamente
             */
            $stmt->execute($params);
<<<<<<< HEAD

=======
            
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
            /**
             * Paso 3: Obtener todos los resultados
             * fetchAll() retorna un array con todas las filas
             * Cada fila es un array asociativo (clave => valor)
             */
            return $stmt->fetchAll();
<<<<<<< HEAD

=======
            
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
        } catch (PDOException $e) {
            // Si hay error SQL, lanzar excepción
            throw new PDOException("Error en executeQuery: " . $e->getMessage());
        }
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: executeQueryOne() - Consultas SELECT (retorna UN registro)
    // ========================================================================

    /**
     * Ejecuta consultas SELECT y retorna SOLO el primer resultado
     * Útil para búsquedas por ID o consultas que retornan un solo registro
     *
=======
    
    // ========================================================================
    // MÉTODO: executeQueryOne() - Consultas SELECT (retorna UN registro)
    // ========================================================================
    
    /**
     * Ejecuta consultas SELECT y retorna SOLO el primer resultado
     * Útil para búsquedas por ID o consultas que retornan un solo registro
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * USO (ejemplo):
     * $db = new Database();
     * $mecanico = $db->executeQueryOne("SELECT * FROM mecanicos WHERE id = ?", [5]);
     * echo $mecanico['nombre']; // Acceso directo sin índice de array
<<<<<<< HEAD
     *
=======
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * @param string $sql Consulta SQL con placeholders ?
     * @param array $params Array de parámetros
     * @return array|null Array asociativo del registro, o null si no existe
     * @throws PDOException
     */
    public function executeQueryOne($sql, $params = []) {
<<<<<<< HEAD

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);

=======
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
            /**
             * fetch() retorna solo la primera fila (no un array de arrays)
             * Retorna false si no hay resultados, por eso se convierte a null
             */
            $resultado = $stmt->fetch();
            return $resultado !== false ? $resultado : null;
<<<<<<< HEAD

=======
            
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
        } catch (PDOException $e) {
            throw new PDOException("Error en executeQueryOne: " . $e->getMessage());
        }
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: executeNonQuery() - INSERT, UPDATE, DELETE
    // ========================================================================

    /**
     * Ejecuta consultas que modifican datos: INSERT, UPDATE, DELETE
     * Retorna el número de filas afectadas
     *
     * USO (ejemplo):
     *
     * INSERT:
     * $sql = "INSERT INTO repuestos (nombre, precio, stock) VALUES (?, ?, ?)";
     * $filas = $db->executeNonQuery($sql, ['Pastilla de freno', 25.50, 10]);
     *
     * UPDATE:
     * $sql = "UPDATE repuestos SET stock = ? WHERE id = ?";
     * $filas = $db->executeNonQuery($sql, [15, 3]);
     *
     * DELETE:
     * $sql = "DELETE FROM repuestos WHERE id = ?";
     * $filas = $db->executeNonQuery($sql, [3]);
     *
=======
    
    // ========================================================================
    // MÉTODO: executeNonQuery() - INSERT, UPDATE, DELETE
    // ========================================================================
    
    /**
     * Ejecuta consultas que modifican datos: INSERT, UPDATE, DELETE
     * Retorna el número de filas afectadas
     * 
     * USO (ejemplo):
     * 
     * INSERT:
     * $sql = "INSERT INTO repuestos (nombre, precio, stock) VALUES (?, ?, ?)";
     * $filas = $db->executeNonQuery($sql, ['Pastilla de freno', 25.50, 10]);
     * 
     * UPDATE:
     * $sql = "UPDATE repuestos SET stock = ? WHERE id = ?";
     * $filas = $db->executeNonQuery($sql, [15, 3]);
     * 
     * DELETE:
     * $sql = "DELETE FROM repuestos WHERE id = ?";
     * $filas = $db->executeNonQuery($sql, [3]);
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * @param string $sql Consulta SQL INSERT/UPDATE/DELETE con placeholders ?
     * @param array $params Array de parámetros
     * @return int Número de filas afectadas por la operación
     * @throws PDOException
     */
    public function executeNonQuery($sql, $params = []) {
<<<<<<< HEAD

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);

            /**
             * rowCount() retorna el número de filas afectadas
             * Útil para validar si la operación fue exitosa
             *
=======
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            
            /**
             * rowCount() retorna el número de filas afectadas
             * Útil para validar si la operación fue exitosa
             * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
             * Ejemplo de uso:
             * $filas = $db->executeNonQuery($sql, $params);
             * if ($filas > 0) {
             *     echo "Registro guardado exitosamente";
             * }
             */
            return $stmt->rowCount();
<<<<<<< HEAD

=======
            
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
        } catch (PDOException $e) {
            throw new PDOException("Error en executeNonQuery: " . $e->getMessage());
        }
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: getLastInsertId() - Obtiene el ID del último INSERT
    // ========================================================================

    /**
     * Retorna el ID auto-incremento del último registro insertado
     * Muy útil para obtener el ID de una factura o cliente recién creado
     *
=======
    
    // ========================================================================
    // MÉTODO: getLastInsertId() - Obtiene el ID del último INSERT
    // ========================================================================
    
    /**
     * Retorna el ID auto-incremento del último registro insertado
     * Muy útil para obtener el ID de una factura o cliente recién creado
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * USO (ejemplo):
     * $sql = "INSERT INTO facturas (cliente, total) VALUES (?, ?)";
     * $db->executeNonQuery($sql, ['Juan Pérez', 150.50]);
     * $facturaID = $db->getLastInsertId();
<<<<<<< HEAD
     *
=======
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * @return string|null El ID del último registro insertado
     */
    public function getLastInsertId() {
        // lastInsertId() retorna el auto_increment del último INSERT
        return $this->conexion->lastInsertId();
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: beginTransaction() - Inicia una transacción
    // ========================================================================

    /**
     * Inicia una transacción para ejecutar múltiples consultas de forma atómica
     * O todo se guarda, o nada se guarda (seguridad de datos)
     *
     * USO (ejemplo):
     * try {
     *     $db->beginTransaction();
     *
     *     $db->executeNonQuery("INSERT INTO facturas...", $params1);
     *     $facturaID = $db->getLastInsertId();
     *
     *     $db->executeNonQuery("INSERT INTO detalle_factura...", $params2);
     *
     *     $db->commit();
     *     echo "Factura guardada exitosamente";
     *
=======
    
    // ========================================================================
    // MÉTODO: beginTransaction() - Inicia una transacción
    // ========================================================================
    
    /**
     * Inicia una transacción para ejecutar múltiples consultas de forma atómica
     * O todo se guarda, o nada se guarda (seguridad de datos)
     * 
     * USO (ejemplo):
     * try {
     *     $db->beginTransaction();
     *     
     *     $db->executeNonQuery("INSERT INTO facturas...", $params1);
     *     $facturaID = $db->getLastInsertId();
     *     
     *     $db->executeNonQuery("INSERT INTO detalle_factura...", $params2);
     *     
     *     $db->commit();
     *     echo "Factura guardada exitosamente";
     *     
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * } catch (Exception $e) {
     *     $db->rollback();
     *     echo "Error: " . $e->getMessage();
     * }
     */
    public function beginTransaction() {
        try {
            $this->conexion->beginTransaction();
        } catch (PDOException $e) {
            throw new PDOException("Error al iniciar transacción: " . $e->getMessage());
        }
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: commit() - Confirma una transacción
    // ========================================================================

=======
    
    // ========================================================================
    // MÉTODO: commit() - Confirma una transacción
    // ========================================================================
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * Confirma todos los cambios de la transacción actual
     * Ver ejemplo en beginTransaction()
     */
    public function commit() {
        try {
            $this->conexion->commit();
        } catch (PDOException $e) {
            throw new PDOException("Error al confirmar transacción: " . $e->getMessage());
        }
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: rollback() - Cancela una transacción
    // ========================================================================

=======
    
    // ========================================================================
    // MÉTODO: rollback() - Cancela una transacción
    // ========================================================================
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * Cancela todos los cambios de la transacción actual
     * Muy útil en bloques catch para deshacer cambios en caso de error
     * Ver ejemplo en beginTransaction()
     */
    public function rollback() {
        try {
            $this->conexion->rollBack();
        } catch (PDOException $e) {
            throw new PDOException("Error al revertir transacción: " . $e->getMessage());
        }
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: getConnection() - Retorna la conexión PDO directa
    // ========================================================================

    /**
     * Retorna la conexión PDO para operaciones avanzadas
     * Úsalo solo si necesitas control total
     *
=======
    
    // ========================================================================
    // MÉTODO: getConnection() - Retorna la conexión PDO directa
    // ========================================================================
    
    /**
     * Retorna la conexión PDO para operaciones avanzadas
     * Úsalo solo si necesitas control total
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * @return PDO La instancia de conexión PDO
     */
    public function getConnection() {
        return $this->conexion;
    }
<<<<<<< HEAD

    // ========================================================================
    // MÉTODO: close() - Cierra la conexión
    // ========================================================================

=======
    
    // ========================================================================
    // MÉTODO: close() - Cierra la conexión
    // ========================================================================
    
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
    /**
     * Cierra la conexión con la base de datos
     * En PHP generalmente se cierra automáticamente al final del script
     * Pero puedes llamarlo manualmente si lo necesitas
<<<<<<< HEAD
     *
=======
     * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
     * USO:
     * $db->close();
     */
    public function close() {
        $this->conexion = null;
    }
}

/**
 * ============================================================================
 * CÓMO USAR ESTA CLASE EN TU PROYECTO
 * ============================================================================
<<<<<<< HEAD
 *
 * PASO 1: En tus controllers, en lugar de:
 *
 *   $model = new MecanicoPepe();
 *   $servicios = $model->executeQuery("SELECT * FROM servicios");
 *
 * Ahora haces:
 *
 *   require_once '../models/Database.php';
 *   $db = new Database();
 *   $servicios = $db->executeQuery("SELECT * FROM servicios");
 *
 *
 * PASO 2: Consultas con parámetros (SEGURO contra SQL Injection):
 *
 *   // Antes (INSEGURO):
 *   $usuario = $_POST['usuario'];
 *   $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'"; // ❌ PELIGRO
 *
=======
 * 
 * PASO 1: En tus controllers, en lugar de:
 * 
 *   $model = new MecanicoPepe();
 *   $servicios = $model->executeQuery("SELECT * FROM servicios");
 * 
 * Ahora haces:
 * 
 *   require_once '../models/Database.php';
 *   $db = new Database();
 *   $servicios = $db->executeQuery("SELECT * FROM servicios");
 * 
 * 
 * PASO 2: Consultas con parámetros (SEGURO contra SQL Injection):
 * 
 *   // Antes (INSEGURO):
 *   $usuario = $_POST['usuario'];
 *   $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'"; // ❌ PELIGRO
 *   
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
 *   // Ahora (SEGURO con PDO):
 *   $usuario = $_POST['usuario'];
 *   $sql = "SELECT * FROM usuarios WHERE usuario = ?";
 *   $resultado = $db->executeQuery($sql, [$usuario]); // ✓ SEGURO
<<<<<<< HEAD
 *
 *
 * PASO 3: Valores retornados:
 *
=======
 * 
 * 
 * PASO 3: Valores retornados:
 * 
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
 *   // executeQuery() retorna un ARRAY de resultados
 *   $servicios = $db->executeQuery("SELECT * FROM servicios");
 *   foreach ($servicios as $servicio) {
 *       echo $servicio['nombre']; // Acceso por clave
 *   }
<<<<<<< HEAD
 *
=======
 *   
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
 *   // executeQueryOne() retorna UN SOLO resultado
 *   $mecanico = $db->executeQueryOne(
 *       "SELECT * FROM mecanicos WHERE id = ?",
 *       [5]
 *   );
 *   if ($mecanico) {
 *       echo $mecanico['nombre'];
 *   } else {
 *       echo "Mecánico no encontrado";
 *   }
<<<<<<< HEAD
 *
 *
 * PASO 4: INSERT con ID generado:
 *
 *   $sql = "INSERT INTO repuestos (nombre, precio, stock) VALUES (?, ?, ?)";
 *   $db->executeNonQuery($sql, ['Aceite 5W30', 45.99, 20]);
 *   $repuestoID = $db->getLastInsertId();
 *
 *
 * PASO 5: Múltiples operaciones con transacción:
 *
 *   try {
 *       $db->beginTransaction();
 *
=======
 * 
 * 
 * PASO 4: INSERT con ID generado:
 * 
 *   $sql = "INSERT INTO repuestos (nombre, precio, stock) VALUES (?, ?, ?)";
 *   $db->executeNonQuery($sql, ['Aceite 5W30', 45.99, 20]);
 *   $repuestoID = $db->getLastInsertId();
 *   
 * 
 * PASO 5: Múltiples operaciones con transacción:
 * 
 *   try {
 *       $db->beginTransaction();
 *       
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
 *       // Insertar factura
 *       $sql1 = "INSERT INTO facturas (cliente, total) VALUES (?, ?)";
 *       $db->executeNonQuery($sql1, ['Juan', 150.00]);
 *       $facturaID = $db->getLastInsertId();
<<<<<<< HEAD
 *
 *       // Insertar detalles de factura
 *       $sql2 = "INSERT INTO detalle_factura (factura_id, servicio_id) VALUES (?, ?)";
 *       $db->executeNonQuery($sql2, [$facturaID, 1]);
 *
 *       // Si todo va bien, confirmar
 *       $db->commit();
 *       echo "✓ Factura guardada correctamente";
 *
=======
 *       
 *       // Insertar detalles de factura
 *       $sql2 = "INSERT INTO detalle_factura (factura_id, servicio_id) VALUES (?, ?)";
 *       $db->executeNonQuery($sql2, [$facturaID, 1]);
 *       
 *       // Si todo va bien, confirmar
 *       $db->commit();
 *       echo "✓ Factura guardada correctamente";
 *       
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
 *   } catch (Exception $e) {
 *       $db->rollback();
 *       echo "❌ Error: " . $e->getMessage();
 *   }
<<<<<<< HEAD
 *
 * ============================================================================
 */
?>
=======
 * 
 * ============================================================================
 */
?>
>>>>>>> 6e33843f9af25084783d67889ee1aa4dc72cf2cf
