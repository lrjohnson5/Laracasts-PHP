<?php

declare(strict_types=1);

/**
 * File Name: Container.php
 * Description: Dependency injection container to manage Class dependencies.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 *  Updated: 2025-07-14 - Added strict types and type hints
 */

namespace Core;

class Container
{
    protected array $bindings = [];

    // bind something into the container
    public function bind(string $key, callable $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    // resolve to grab things out of the container
    public function resolve(string $key): mixed
    {
        if (! array_key_exists($key, $this->bindings)) {
            throw new \Exception("No matching binding found for {$key}");
        }

        $resolver = $this->bindings[$key];
        return call_user_func($resolver);
    }

}