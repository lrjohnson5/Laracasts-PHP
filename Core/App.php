<?php

/**
 * File Name: App.php
 * Description: Manages application initialization and execution through the use of containers.
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core;

class App {
    protected static $container;

    public static function setContainer($container) {
        static::$container = $container;
    }

    public static function container() {
        return static::$container;
    }

    public static function bind($key, $resolver) {
        static::container()->bind($key);
    }

    public static function resolve($key) {
        return static::container()->resolve($key);
    }
}