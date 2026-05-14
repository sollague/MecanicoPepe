<?php
<<<<<<< HEAD
/**
 * ============================================================================
 * USUARIO CONTROLLER - REFACTORIZADO A PDO
 * ============================================================================
 * 
 * Este controller maneja el login de usuarios
 * 
 * CAMBIOS RESPECTO A LA VERSIÓN ANTIGUA:
 * ✓ Usa PDO en lugar de mysqli
 * ✓ Prepared statements para seguridad contra SQL Injection
 * ✓ Validaciones mejoradas
 * ✓ Manejo de errores robusto
 * ✓ Comentarios detallados en cada paso
 * 
 * UBICACIÓN: controllers/UsuarioController.php
 * ============================================================================
 */

/**
 * Iniciar sesión
 * Debe estar al INICIO del archivo, antes de cualquier output
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Incluir la clase Database (PDO)
 * Ruta relativa: desde controllers/ subir a raíz, luego ir a models/
 */
require_once '../models/Database.php';

/**
 * ============================================================================
 * VALIDAR QUE SEA UNA SOLICITUD POST
 * ============================================================================
 * 
 * Verificar que la solicitud sea POST (formulario enviado)
 * Prevenir acceso directo por URL
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    /**
     * Si no es POST, redirigir a login
     */
    header('Location: ../views/login_view.php');
    exit();
}

/**
 * ============================================================================
 * OBTENER DATOS DEL FORMULARIO
 * ============================================================================
 * 
 * Recuperar usuario y contraseña del formulario
 * isset() verifica que la variable exista
 * trim() elimina espacios al inicio/final
 */
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

/**
 * ============================================================================
 * VALIDACIÓN 1: CAMPOS VACÍOS
 * ============================================================================
 */
if (empty($usuario) || empty($password)) {
    /**
     * Si algún campo está vacío:
     * 1. Guardar el error en SESSION
     * 2. Redirigir a login
     * 3. Salir del script
     */
    $_SESSION['error'] = '❌ Usuario y contraseña son requeridos';
    header('Location: ../views/login_view.php');
    exit();
}

/**
 * ============================================================================
 * VALIDACIÓN 2: LONGITUD DE CAMPOS
 * ============================================================================
 */
if (strlen($usuario) < 2 || strlen($usuario) > 50) {
    $_SESSION['error'] = '❌ Usuario debe tener entre 2 y 50 caracteres';
    header('Location: ../views/login_view.php');
    exit();
}

if (strlen($password) < 2 || strlen($password) > 100) {
    $_SESSION['error'] = '❌ Contraseña debe tener entre 2 y 100 caracteres';
    header('Location: ../views/login_view.php');
    exit();
}

/**
 * ============================================================================
 * CREAR INSTANCIA DE DATABASE (PDO)
 * ============================================================================
 * 
 * Instanciar la clase Database
 * Esto automáticamente:
 * 1. Conecta a la BD con PDO
 * 2. Configura prepared statements
 * 3. Lanza excepciones en errores
 * 
 * Si falla la conexión, se muestra un error y se detiene
 */
try {
    $db = new Database();
} catch (Exception $e) {
    /**
     * Si hay error de conexión a la BD
     */
    $_SESSION['error'] = '❌ Error de conexión a la base de datos';
    header('Location: ../views/login_view.php');
    exit();
}

/**
 * ============================================================================
 * CONSULTA A LA BASE DE DATOS
 * ============================================================================
 * 
 * NOTA IMPORTANTE: Por ahora usamos credentials hardcoded (admin/1234)
 * Pero este código está preparado para buscar en una tabla usuarios si existe
 * 
 * Cuando implementes tabla de usuarios, descomentar:
 * 
 * $sql = "SELECT * FROM usuarios WHERE usuario = ?";
 * $resultado = $db->executeQueryOne($sql, [$usuario]);
 * 
 * if ($resultado && password_verify($password, $resultado['password_hash'])) {
 *     // Login exitoso
 * } else {
 *     // Usuario o contraseña incorrectos
 * }
 */

/**
 * ============================================================================
 * VALIDACIÓN 3: CREDENCIALES HARDCODED (TEMPORAL)
 * ============================================================================
 * 
 * Actualmente el sistema usa:
 * - usuario: admin
 * - password: 1234
 * 
 * Esto es temporal. Cuando implementes tabla de usuarios con hashing,
 * usar el método de arriba (ver comentario)
 */
$usuarioValido = 'admin';
$passwordValida = '1234';

/**
 * Comparar credenciales
 * strcmp() compara strings de forma segura
 */
if ($usuario === $usuarioValido && $password === $passwordValida) {
    /**
     * ======================================================================
     * ✓ CREDENCIALES CORRECTAS
     * ======================================================================
     */
    
    /**
     * Regenerar ID de sesión
     * Previene session fixation attacks
     * Importante para seguridad
     */
    session_regenerate_id(true);
    
    /**
     * Guardar usuario en SESSION
     * Se usará para:
     * 1. Verificar que el usuario está autenticado
     * 2. Mostrar nombre en el dashboard
     * 3. Registrar quién hizo cada acción
     */
    $_SESSION['usuario'] = $usuario;
    
    /**
     * Guardar timestamp de login
     * Útil para controlar sesiones que expiran por inactividad
     */
    $_SESSION['login_time'] = time();
    
    /**
     * Guardar IP del usuario (opcional pero recomendado)
     * Detectar acceso desde IPs sospechosas
     */
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    
    /**
     * Limpiar cualquier error anterior
     */
    unset($_SESSION['error']);
    
    /**
     * Registrar login en log (RECOMENDADO)
     * Útil para auditoría y seguridad
     * Descomentar cuando implemente sistema de logs
     */
    // error_log("[LOGIN EXITOSO] Usuario: $usuario | IP: " . $_SERVER['REMOTE_ADDR'] . " | Fecha: " . date('Y-m-d H:i:s'));
    
    /**
     * Redirigir al dashboard
     */
    header('Location: ../views/dashboard_view.php');
    exit();
    
} else {
    /**
     * ======================================================================
     * ❌ CREDENCIALES INCORRECTAS
     * ======================================================================
     */
    
    /**
     * Guardar mensaje de error en SESSION
     * Se mostrará en la vista de login
     */
    $_SESSION['error'] = '❌ Usuario o contraseña incorrectos';
    
    /**
     * Registrar intento fallido en log
     * IMPORTANTE para detectar intentos de acceso no autorizados
     * Descomentar cuando implemente sistema de logs
     */
    // error_log("[LOGIN FALLIDO] Usuario: $usuario | IP: " . $_SERVER['REMOTE_ADDR'] . " | Fecha: " . date('Y-m-d H:i:s'));
    
    /**
     * Redirigir a login (permanecerá en login_view.php)
     */
    header('Location: ../views/login_view.php');
    exit();
}

/**
 * ============================================================================
 * MEJORAS FUTURAS (CUANDO IMPLEMENTES TABLA DE USUARIOS)
 * ============================================================================
 * 
 * 1. PASSWORD HASHING
 *    Usar password_hash() en PHP para guardar contraseñas de forma segura
 *    
 *    // Al crear usuario:
 *    $hash = password_hash($password, PASSWORD_DEFAULT);
 *    // Guardar $hash en BD
 *    
 *    // Al hacer login:
 *    if (password_verify($passwordIngresado, $hashDeBaseDatos)) {
 *        // Contraseña correcta
 *    }
 * 
 * 2. TABLA DE USUARIOS EN BD
 *    CREATE TABLE usuarios (
 *        id INT AUTO_INCREMENT PRIMARY KEY,
 *        usuario VARCHAR(50) UNIQUE NOT NULL,
 *        password_hash VARCHAR(255) NOT NULL,
 *        email VARCHAR(100),
 *        rol VARCHAR(50),
 *        activo BOOLEAN DEFAULT 1,
 *        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 *    );
 * 
 * 3. CONTROL DE INTENTOS FALLIDOS
 *    Bloquear usuario temporalmente después de N intentos fallidos
 * 
 * 4. TWO-FACTOR AUTHENTICATION (2FA)
 *    Enviar código por email o SMS
 * 
 * 5. REMEMBER ME
 *    Guardar cookie segura para login automático
 * 
 * 6. TIMEOUT DE SESIÓN
 *    Cerrar sesión después de X minutos de inactividad
 * 
 * ============================================================================
 */

?>
=======
session_start();

require_once("../models/MecanicoPepe.php");

$model = new MecanicoPepe();

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "
SELECT * FROM usuarios
WHERE usuario = '$usuario'
AND password = '$password'
";

$resultado = $model->executeQuery($sql);

if (count($resultado) > 0) {

    $_SESSION['usuario'] = $usuario;

    header(
        "Location: ../views/dashboard_view.php"
    );

} else {

    echo "Credenciales incorrectas";
}
>>>>>>> ce0c85bcebcc1f77ba1f46c47826e98c9b2c414c
