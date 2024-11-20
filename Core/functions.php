<?php

/**
 * File Name: functions.php
 * Description: Helper functions used throughout the app.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

use Core\Response;

function dd($value, $die = true) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';

    if ($die) {
        die;
    };
}

function urlIs($value): bool
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404) {
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Response::FORBIDDEN) {
    if (! $condition) {
        abort($status);
    }
}

function base_path($path): string
{
    return BASE_PATH . $path;
}

function view($path, $attributes = []) {
    extract($attributes);
    require base_path('views/' . $path);
}

function redirect($path) {
    header("location: {$path}");
    exit();
}

function old($key, $default = '') {
    return Core\Session::get('old')[$key] ?? $default;
}