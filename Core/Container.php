<?php

namespace Core;

class Container
{
    protected $bindings = [];

    // bind something into the container
    public function bind($key, $resolver) {
        $this->bindings[$key] = $resolver;
    }

    // resolve to grab things out of the container
    public function resolve($key) {
        if (! array_key_exists($key, $this->bindings)) {
            throw new \Exception("No binding defined for key: {$key}");
        }

        $resolver = $this->bindings[$key];
        return call_user_func($resolver);
    }

}