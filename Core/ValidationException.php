<?php

/**
 * File Name: ValidationException.php
 * Description: Custom exception for validation errors.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core;

class ValidationException extends \Exception
{
    public readonly array $errors;
    public readonly array $old;

    public static function throw($errors, $old)
    {
        $instance = new static('The form failed to validate.');

        $instance->errors = $errors;
        $instance->old = $old;

        throw $instance;
    }
}