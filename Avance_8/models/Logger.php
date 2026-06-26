<?php

/**
 * Class Logger
 *
 * Provee funciones estáticas para registrar errores y eventos de auditoría.
 * El método error escribe en el log de PHP y audit escribe en un archivo JSONL
 * para seguimiento de operaciones críticas.
 */
class Logger
{
    /**
     * Escribe un mensaje de error en el log de PHP con marca de tiempo.
     */
    public static function error(string $mensaje): void
    {
        error_log("[" . date("Y-m-d H:i:s") . "] " . $mensaje);
    }

    /**
     * Registra un evento de auditoría/mantenimiento en un archivo JSONL.
     * Espera un arreglo con claves como: date, responsable, modulo, accion,
     * descripcion, resultado, y opcionalmente detalle.
     */
    public static function audit(array $meta): void
    {
        $logsDir = __DIR__ . '/../logs';
        if (!is_dir($logsDir)) {
            @mkdir($logsDir, 0750, true);
        }

        $file = $logsDir . '/maintenance.log';

        $entry = array_merge([
            'date' => date('c'),
            'responsable' => $meta['responsable'] ?? 'system',
            'modulo' => $meta['modulo'] ?? 'unknown',
            'accion' => $meta['accion'] ?? 'unknown',
            'descripcion' => $meta['descripcion'] ?? '',
            'resultado' => $meta['resultado'] ?? 'started',
        ], $meta);

        // Escribir línea JSON para facilitar ingestión y auditoría
        @file_put_contents($file, json_encode($entry, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX);
    }
}
