<?php

class Logger
{
    public static function error(string $mensaje): void
    {
        error_log("[" . date("Y-m-d H:i:s") . "] " . $mensaje);
    }
}
