<?php

declare(strict_types=1);

/**
 * File Name: Validator.php
 * Description: Enhanced input validation with security features.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 * Updated: 2025-07-14 - Added strict types and comprehensive validation
 */

namespace Core;

class Validator
{
    public static function string(mixed $value, int $min = 1, int $max = INF): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $value = trim($value);
        $length = strlen($value);

        return $length >= $min && $length <= $max;
    }

    public static function email(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function numeric(mixed $value): bool
    {
        return is_numeric($value);
    }

    public static function integer(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    public static function url(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    public static function required(mixed $value): bool
    {
        if (is_string($value)) {
            return trim($value) !== '';
        }

        return $value !== null && $value !== '' && $value !== [];
    }

    public static function min(mixed $value, int $min): bool
    {
        if (is_string($value)) {
            return strlen(trim($value)) >= $min;
        }

        if (is_numeric($value)) {
            return $value >= $min;
        }

        return false;
    }

    public static function max(mixed $value, int $max): bool
    {
        if (is_string($value)) {
            return strlen(trim($value)) <= $max;
        }

        if (is_numeric($value)) {
            return $value <= $max;
        }

        return false;
    }

    public static function regex(mixed $value, string $pattern): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return preg_match($pattern, $value) === 1;
    }

    public static function noXss(mixed $value): bool
    {
        if (!is_string($value)) {
            return true;
        }

        // Check for common XSS patterns
        $xssPatterns = [
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi',
            '/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload=/i',
            '/onerror=/i',
            '/onclick=/i',
            '/onmouseover=/i',
        ];

        foreach ($xssPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return false;
            }
        }

        return true;
    }

    public static function noSqlInjection(mixed $value): bool
    {
        if (!is_string($value)) {
            return true;
        }

        // Check for common SQL injection patterns
        $sqlPatterns = [
            '/union\s+select/i',
            '/drop\s+table/i',
            '/delete\s+from/i',
            '/insert\s+into/i',
            '/update\s+set/i',
            '/or\s+1\s*=\s*1/i',
            '/and\s+1\s*=\s*1/i',
            '/\/\*.*\*\//s',
            '/--/i',
            '/;.*$/i',
        ];

        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return false;
            }
        }

        return true;
    }

    public static function between(mixed $value, int $min, int $max): bool
    {
        if (is_string($value)) {
            $length = strlen(trim($value));
            return $length >= $min && $length <= $max;
        }

        if (is_numeric($value)) {
            return $value >= $min && $value <= $max;
        }

        return false;
    }

    public static function in(mixed $value, array $options): bool
    {
        return in_array($value, $options, true);
    }

    public static function notIn(mixed $value, array $options): bool
    {
        return !in_array($value, $options, true);
    }

    public static function alpha(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return preg_match('/^[a-zA-Z]+$/', $value) === 1;
    }

    public static function alphaNumeric(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return preg_match('/^[a-zA-Z0-9]+$/', $value) === 1;
    }

    public static function unique(mixed $value, string $table, string $column): bool
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        $db = App::resolve(Database::class);
        $result = $db->query(
            "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :value",
            ['value' => $value]
        )->find();

        return $result['count'] == 0;
    }

    public static function exists(mixed $value, string $table, string $column): bool
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        $db = App::resolve(Database::class);
        $result = $db->query(
            "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :value",
            ['value' => $value]
        )->find();

        return $result['count'] > 0;
    }

    public static function date(mixed $value, string $format = 'Y-m-d'): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $dateTime = \DateTime::createFromFormat($format, $value);
        return $dateTime !== false && $dateTime->format($format) === $value;
    }

    public static function boolean(mixed $value): bool
    {
        return is_bool($value) ||
            in_array($value, [1, 0, '1', '0', 'true', 'false', 'on', 'off', 'yes', 'no'], true);
    }

    /**
     * Validate multiple rules for a field
     */
    public static function validate(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            $fieldRules = is_string($fieldRules) ? explode('|', $fieldRules) : $fieldRules;

            foreach ($fieldRules as $rule) {
                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                $ruleParams = $ruleParts[1] ?? '';

                $isValid = match ($ruleName) {
                    'required' => self::required($value),
                    'email' => self::email($value),
                    'numeric' => self::numeric($value),
                    'integer' => self::integer($value),
                    'url' => self::url($value),
                    'alpha' => self::alpha($value),
                    'alphaNumeric' => self::alphaNumeric($value),
                    'boolean' => self::boolean($value),
                    'min' => self::min($value, (int) $ruleParams),
                    'max' => self::max($value, (int) $ruleParams),
                    'string' => $ruleParams ?
                        self::string($value, ...explode(',', $ruleParams)) :
                        self::string($value),
                    'between' => self::between($value, ...explode(',', $ruleParams)),
                    'in' => self::in($value, explode(',', $ruleParams)),
                    'notIn' => self::notIn($value, explode(',', $ruleParams)),
                    'unique' => self::unique($value, ...explode(',', $ruleParams)),
                    'exists' => self::exists($value, ...explode(',', $ruleParams)),
                    'date' => $ruleParams ? self::date($value, $ruleParams) : self::date($value),
                    'regex' => self::regex($value, $ruleParams),
                    'noXss' => self::noXss($value),
                    'noSqlInjection' => self::noSqlInjection($value),
                    default => true
                };

                if (!$isValid) {
                    $errors[$field][] = "The {$field} field failed {$ruleName} validation.";
                }
            }
        }

        return $errors;
    }
}
