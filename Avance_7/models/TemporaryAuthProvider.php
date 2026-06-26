<?php

require_once __DIR__ . '/AuthProviderInterface.php';

/**
 * TemporaryAuthProvider
 *
 * Implementación temporal de `AuthProviderInterface` pensada solo para
 * entornos de desarrollo. No almacenar credenciales en el código.
 *
 * Uso: establecer `APP_ADMIN_USER` y `APP_ADMIN_PASS` en variables de entorno.
 */
class TemporaryAuthProvider implements AuthProviderInterface
{
    // Usuario temporal: reemplazar por un proveedor real en producción
    private array $allowedUsers = [];

    /**
     * Carga credenciales desde variables de entorno y las hashea.
     */
    public function __construct()
    {
        // Cargar credenciales desde variables de entorno para no hardcodear
        $adminUser = getenv('APP_ADMIN_USER') ?: null;
        $adminPass = getenv('APP_ADMIN_PASS') ?: null;

        if ($adminUser && $adminPass) {
            // Almacenar contraseña hasheada
            $this->allowedUsers[$adminUser] = password_hash($adminPass, PASSWORD_DEFAULT);
        }
    }

    /**
     * Verifica las credenciales usando `password_verify`.
     *
     * @param string $usuario
     * @param string $contrasena
     * @return bool
     */
    public function validateCredentials(string $usuario, string $contrasena): bool
    {
        if (!isset($this->allowedUsers[$usuario])) {
            return false;
        }

        return password_verify($contrasena, $this->allowedUsers[$usuario]);
    }
}
