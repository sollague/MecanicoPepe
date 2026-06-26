<?php

class Validator
{
    public static function required(array $fields, array $data): bool
    {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                return false;
            }
        }

        return true;
    }

    public static function lengthBetween(string $value, int $min, int $max): bool
    {
        $length = mb_strlen(trim($value));
        return $length >= $min && $length <= $max;
    }

    public static function isPositiveNumber($value, float $min = 0): bool
    {
        return is_numeric($value) && (float) $value >= $min;
    }

    public static function isValidId($value): bool
    {
        return is_numeric($value) && (int) $value > 0;
    }

    public static function sanitizeText(string $value): string
    {
        return trim(strip_tags($value));
    }

    public static function sanitizeInt($value): int
    {
        return (int) round((float) $value);
    }

    public static function validateCedula(string $cedula): bool
    {
        return preg_match('/^[0-9]{10}$/', trim($cedula)) === 1;
    }
}
