<?php

require_once __DIR__ . '/Response.php';

/**
 * Class SessionManager
 *
 * Administra el ciclo de vida de la sesión del usuario.
 * Centraliza la inicialización, inicio de sesión, cierre y verificación.
 */
class SessionManager
{
    /**
     * Inicia la sesión si no está iniciada.
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Registra el usuario en la sesión tras un login válido.
     */
    public static function login(string $username): void
    {
        self::start();
        session_regenerate_id(true);
        $_SESSION['usuario'] = $username;
        $_SESSION['login_time'] = time();
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'] ?? '';
    }

    /**
     * Cierra la sesión y elimina la cookie de sesión si existe.
     */
    public static function logout(): void
    {
        self::start();
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']
            );
        }

        session_destroy();
    }

    /**
     * Comprueba si actualmente hay un usuario logueado.
     */
    public static function isLoggedIn(): bool
    {
        self::start();
        return !empty($_SESSION['usuario']);
    }

    /**
     * Obliga a que exista una sesión válida o redirige al login.
     */
    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            Response::withError('Debe iniciar sesión', '../views/login_view.php');
        }
    }
}

?>
