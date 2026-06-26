<?php

/**
 * Class Csrf
 *
 * Módulo simple para generar y validar tokens CSRF por formulario.
 * Mantiene tokens en la sesión y permite proteger formularios contra
 * envío malicioso desde sitios externos.
 */
class Csrf
{
    private const SESSION_KEY = '_csrf_tokens';

    /**
     * Asegura que la sesión esté iniciada y que exista el arreglo de tokens.
     */
    private static function ensureSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    /**
     * Genera un token para un identificador de formulario y lo guarda en sesión.
     */
    public static function generateToken(string $formId = 'default'): string
    {
        self::ensureSession();

        $token = bin2hex(random_bytes(16));
        $_SESSION[self::SESSION_KEY][$formId] = [
            'token' => $token,
            'created_at' => time(),
        ];

        return $token;
    }

    /**
     * Verifica la validez de un token para un formulario dado.
     * El token se consume al usarlo una vez y tiene una vida limitada.
     */
    public static function validateToken(?string $token, string $formId = 'default', int $ttl = 900): bool
    {
        self::ensureSession();

        if (!$token) {
            return false;
        }

        if (!isset($_SESSION[self::SESSION_KEY][$formId])) {
            return false;
        }

        $record = $_SESSION[self::SESSION_KEY][$formId];

        // Expiración simple basada en TTL en segundos
        if (isset($record['created_at']) && (time() - (int) $record['created_at']) > $ttl) {
            unset($_SESSION[self::SESSION_KEY][$formId]);
            return false;
        }

        $valid = hash_equals($record['token'], $token);

        // Consumir token para prevenir reutilización
        unset($_SESSION[self::SESSION_KEY][$formId]);

        return $valid;
    }

    /**
     * Devuelve un campo oculto HTML con el token CSRF para incluir en formularios.
     */
    public static function inputField(string $formId = 'default'): string
    {
        $token = self::generateToken($formId);
        $name = '_csrf_token';

        return "<input type=\"hidden\" name=\"{$name}\" value=\"{$token}\">";
    }
}

?>
