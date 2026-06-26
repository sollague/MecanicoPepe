<?php

class Response
{
    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }

    public static function withError(string $message, string $url): void
    {
        $_SESSION["error"] = $message;
        self::redirect($url);
    }

    public static function withSuccess(string $message, string $url): void
    {
        $_SESSION["success"] = $message;
        self::redirect($url);
    }
}
