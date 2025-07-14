<?php

declare(strict_types=1);

/**
 * File Name: ValidationException.php
 * Description: Custom exception for validation errors.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 * Updated: 2025-07-14 - Added strict types and enhanced functionality
 */

namespace Core;

use Exception;

class ValidationException extends Exception
{
    protected array $errors;
    protected array $old;

    public function __construct(array $errors, array $old = [])
    {
        $this->errors = $errors;
        $this->old = $old;

        parent::__construct('Validation failed');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getOld(): array
    {
        return $this->old;
    }

    public function hasError(string $field): bool
    {
        return isset($this->errors[$field]);
    }

    public function getError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    public function getErrorsForField(string $field): array
    {
        return $this->errors[$field] ?? [];
    }

    public function toArray(): array
    {
        return [
            'errors' => $this->errors,
            'old' => $this->old
        ];
    }
}
