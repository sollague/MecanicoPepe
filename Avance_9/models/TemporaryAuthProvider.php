<?php

require_once __DIR__ . '/AuthProviderInterface.php';
require_once __DIR__ . '/Logger.php';
require_once __DIR__ . '/MecanicoPepe.php';

/**
 * TemporaryAuthProvider
 *
 * Implementación temporal de `AuthProviderInterface` pensada para entornos de
 * desarrollo. Valida credenciales contra la tabla `usuarios` de la base de
 * datos y, como respaldo, también admite variables de entorno.
 */
class TemporaryAuthProvider implements AuthProviderInterface
{
    private array $allowedUsers = [];
    private ?MecanicoPepe $db = null;

    public function __construct()
    {
        try {
            $this->db = new MecanicoPepe();
        } catch (Exception $e) {
            Logger::error('No se pudo inicializar conexión para auth: ' . $e->getMessage());
            $this->db = null;
        }

        $adminUser = getenv('APP_ADMIN_USER') ?: null;
        $adminPass = getenv('APP_ADMIN_PASS') ?: null;

        if ($adminUser && $adminPass) {
            $this->allowedUsers[$adminUser] = password_hash($adminPass, PASSWORD_DEFAULT);
        }
    }

    /**
     * Verifica las credenciales usando la tabla `usuarios` o fallback a env.
     *
     * @param string $usuario
     * @param string $contrasena
     * @return bool
     */
    public function validateCredentials(string $usuario, string $contrasena): bool
    {
        if ($this->db !== null) {
            try {
                $result = $this->db->executeQuery(
                    'SELECT password FROM usuarios WHERE username = ? LIMIT 1',
                    [$usuario]
                );

                if (!empty($result) && isset($result[0]['password'])) {
                    return password_verify($contrasena, $result[0]['password']);
                }
            } catch (Exception $e) {
                Logger::error('Error al validar credenciales en DB: ' . $e->getMessage());
            }
        }

        if (!isset($this->allowedUsers[$usuario])) {
            return false;
        }

        return password_verify($contrasena, $this->allowedUsers[$usuario]);
    }
}
