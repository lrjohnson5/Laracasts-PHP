<?php

/**
 * File Name: Router.php
 * Description: Manages routing logic, mapping requests to controllers.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core;

use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller) {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this; // allows continued chaining of methods off of this method, as in the only() method further below
    }

    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }


    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }


    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function only($key) {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }
    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
                Middleware::resolve($route['middleware']);

                // dd($route, false);

                return require base_path('Http/controllers/' . $route['controller']);
            }
        }

        // dd($uri . "+" . $method, false);

        $this->abort();
    }

    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }

}
