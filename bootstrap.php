<?php

declare(strict_types=1);

use Core\App;
use Core\Container;
use Core\Database;

// Load the new comprehensive configuration
$config = require base_path('config/app.php');

// Set error reporting based on environment
if ($config['app']['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('display_errors', '0');
}

// Configure session
$sessionConfig = $config['session'];
ini_set('session.gc_maxlifetime', (string) $sessionConfig['lifetime']);
ini_set('session.cookie_secure', $sessionConfig['secure'] ? '1' : '0');
ini_set('session.cookie_httponly', $sessionConfig['httponly'] ? '1' : '0');
ini_set('session.cookie_samesite', $sessionConfig['samesite']);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$container = new Container();

// Building up the Database object using new config structure
$container->bind('Core\\Database', function () use ($config) {
    return new Database($config['database']);
});

App::setContainer($container);