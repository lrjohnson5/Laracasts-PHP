<?php

declare(strict_types=1);

/**
 * File Name: App.php
 * Description: Manages application initialization and execution through the use of containers.
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 *  Updated: 2025-07-14 - Added strict types
 */

namespace Core;

class App {
    protected static Container $container;

    public static function setContainer(Container $container): void
    {
        static::$container = $container;
    }

    public static function container(): Container
    {
        return static::$container;
    }

    public static function bind(string $key, callable $resolver): void
    {
        static::container()->bind($key, $resolver);
    }

    public static function resolve(string $key): mixed
    {
        return static::container()->resolve($key);
    }
}