<?php

declare(strict_types=1);

/**
 * File Name: Middleware.php
 * Description: Base middleware class.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 *  Updated: 2025-07-14 - Added strict types only
 */

namespace Core\Middleware;

use Exception;

class Middleware
{
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class,
        'confirmed' => EmailConfirmed::class,
        'csrf' => VerifyCsrfToken::class
    ];

    public static function resolve(string $key): void
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;
        
        if (!$middleware) {
            throw new Exception("No matching middleware found for key '{$key}'.");
        }
        (new $middleware)->handle();
    }
}