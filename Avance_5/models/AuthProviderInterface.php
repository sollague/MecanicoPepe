<?php

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
