<?php

require_once __DIR__ . '/AuthProviderInterface.php';

class TemporaryAuthProvider implements AuthProviderInterface
{
    private array $allowedUsers = [
        'admin' => '1234',
    ];

    public function validateCredentials(string $usuario, string $contrasena): bool
    {
        return isset($this->allowedUsers[$usuario]) &&
            $this->allowedUsers[$usuario] === $contrasena;
    }
}
