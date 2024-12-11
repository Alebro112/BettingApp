<?php

namespace App\Core;

use \DateTime;

class Validator
{
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validateDate(string $date): bool
    {
        return (bool) strtotime($date);
    }

    public static function validateAge(string $date, int $age): bool
    {
        $date = new DateTime($date);
        $today = new DateTime();
        $currentAge = $today->diff($date)->y;
        return $currentAge >= $age;
    }

    public static function validateStringLength(string $string, int $min, int $max): bool
    {
        $length = strlen($string);

        return $length >= $min && $length <= $max;
    }

    public static function validateIsFloat(string $string): bool {
        return filter_var($string, FILTER_VALIDATE_FLOAT);
    }

    public static function validateNumber(int $number, int $min, int $max): bool
    {
        return $number >= $min && $number <= $max;
    }

    public static function validateIsBool(bool $bool): bool
    {
        return filter_var($bool, FILTER_VALIDATE_BOOLEAN);
    }

    public static function validateRequiredFields(array $fields, array $data): array
    {
        $errors = [];
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $errors[] = "Поле {$field} обязательно для заполнения.";
            }
        }
        return $errors;
    }

    public static function validateIsStringInArray(array $array, string $string): bool
    {
        return in_array($string, $array, true);
    }
}