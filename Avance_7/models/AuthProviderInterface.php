<?php

/**
 * Interface AuthProviderInterface
 *
 * Define el contrato para proveedores de autenticación. Permite cambiar
 * fácilmente entre implementaciones reales o de prueba.
 */
interface AuthProviderInterface
{
    /**
     * Valida las credenciales de acceso.
     *
     * @param string $usuario
     * @param string $contrasena
     * @return bool
     */
    public function validateCredentials(string $usuario, string $contrasena): bool;
}
