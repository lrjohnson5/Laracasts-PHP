<?php

declare(strict_types=1);

/**
 * File Name: Router.php
 * Description: Manages routing logic, mapping requests to controllers.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 * Updated: 2025-07-14 - Added strict types and security improvements
 */

namespace Core;

use Core\Middleware\Middleware;

class Router
{
    protected array $routes = [];

    public function add(string $method, string $uri, string $controller): self
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this; // allows continued chaining of methods off of this method, as in the only() method further below
    }

    public function get(string $uri, string $controller): self
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post(string $uri, string $controller): self
    {
        return $this->add('POST', $uri, $controller);
    }


    public function delete(string $uri, string $controller): self
    {
        return $this->add('DELETE', $uri, $controller);
    }


    public function patch(string $uri, string $controller): self
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put(string $uri, string $controller): self
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function only(string $key): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }
    public function route(string $uri, string $method): mixed
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
                Middleware::resolve($route['middleware']);
                return require base_path('Http/controllers/' . $route['controller']);
            }
        }

        $this->abort();
    }

    public function previousUrl(): string
    {
        return $_SERVER['HTTP_REFERER'] ?? '/';
    }

    protected function abort(int $code = Response::NOT_FOUND): never
    {
        http_response_code($code);
        require base_path("views/{$code}.php");
        die();
    }

    public function routeExists(string $uri, string $method): bool
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
                return true;
            }
        }
        return false;
    }
}
