<?php

/**
 * File Name: Middleware.php
 * Description: Base middleware class.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core\Middleware;

class Middleware
{
    const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class,
        'confirmed' => EmailConfirmed::class
    ];

    public static function resolve($key) {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;
        
        if (!$middleware) {
            throw new \Exception("No matching middleware found for key '{$key}'.");
        }
        (new $middleware)->handle();
    }
}