<?php

/**
 * Class Validator
 *
 * Colección de funciones utilitarias para validar y sanitizar entradas.
 * Usar estas funciones antes de persistir o procesar datos proporcionados por usuarios.
 */
class Validator
{
    /**
     * Verifica que los campos requeridos estén presentes y no vacíos.
     *
     * @param array $fields Nombres de campos esperados
     * @param array $data Datos a validar
     * @return bool
     */
    public static function required(array $fields, array $data): bool
    {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Verifica que la longitud de una cadena esté entre los límites dados.
     *
     * @param string $value
     * @param int $min
     * @param int $max
     * @return bool
     */
    public static function lengthBetween(string $value, int $min, int $max): bool
    {
        $length = mb_strlen(trim($value));
        return $length >= $min && $length <= $max;
    }

    /**
     * Comprueba que un valor sea numérico y mayor o igual a un mínimo.
     *
     * @param mixed $value
     * @param float $min
     * @return bool
     */
    public static function isPositiveNumber($value, float $min = 0): bool
    {
        return is_numeric($value) && (float) $value >= $min;
    }

    /**
     * Valida que el identificador sea un entero positivo.
     *
     * @param mixed $value
     * @return bool
     */
    public static function isValidId($value): bool
    {
        return is_numeric($value) && (int) $value > 0;
    }

    /**
     * Sanitiza texto removiendo etiquetas HTML y espacios en los extremos.
     *
     * @param string $value
     * @return string
     */
    public static function sanitizeText(string $value): string
    {
        return trim(strip_tags($value));
    }

    /**
     * Convierte un valor a entero de forma segura.
     *
     * @param mixed $value
     * @return int
     */
    public static function sanitizeInt($value): int
    {
        return (int) round((float) $value);
    }

    /**
     * Valida una cédula ecuatoriana simple (10 dígitos).
     *
     * @param string $cedula
     * @return bool
     */
    public static function validateCedula(string $cedula): bool
    {
        return preg_match('/^[0-9]{10}$/', trim($cedula)) === 1;
    }
}
