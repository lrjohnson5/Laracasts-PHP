<?php

declare(strict_types=1);

/**
 * File Name: Session.php
 * Description: Manages user sessions.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 * Updated: 2025-07-14 - Added strict types and security improvements
 */

namespace Core;

class Session
{
    public static function has(string $key): bool
    {
        return (bool) static::get($key);
    }
    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash(): void
    {
        unset($_SESSION['_flash']);
    }

    public static function flush(): void
    {
        $_SESSION = [];
    }

    public static function destroy(): void
    {
        static::flush();

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }


        $params = session_get_cookie_params();
        setcookie(
            'PHPSESSID',
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']);
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public static function id(): string
    {
        return session_id();
    }

    public static function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function all(): array
    {
        return $_SESSION;
    }

    public static function token(): string
    {
        if (!static::has('_token')) {
            static::put('_token', bin2hex(random_bytes(32)));
        }

        return static::get('_token');
    }
}