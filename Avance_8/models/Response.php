<?php

/**
 * Class Response
 *
 * Maneja respuestas HTTP simples y redirecciones del flujo de aplicación.
 * Permite enviar mensajes de éxito o error mediante la sesión antes de
 * redirigir al usuario a otra página.
 */
class Response
{
    /**
     * Redirige a una URL relativa o absoluta y detiene la ejecución.
     */
    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }

    /**
     * Guarda un mensaje de error en sesión y redirige a la URL indicada.
     * También puede preservar los datos del formulario cuando regresamos.
     */
    public static function withError(string $message, string $url, array $oldInput = []): void
    {
        $_SESSION["error"] = $message;

        if (!empty($oldInput)) {
            $_SESSION["old_input"] = $oldInput;
        }

        self::redirect($url);
    }

    /**
     * Guarda un mensaje de éxito en sesión y redirige a la URL indicada.
     */
    public static function withSuccess(string $message, string $url): void
    {
        unset($_SESSION["old_input"]);
        $_SESSION["success"] = $message;
        self::redirect($url);
    }
}
