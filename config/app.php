<?php

declare(strict_types=1);

/**
 * File Name: app.php
 * Description: Complete application configuration with environment-specific settings
 * Author: Updated for PHP MVC Boilerplate
 * Created Date: 2025-07-14
 */

// Load environment variables if .env exists
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

// Get current environment
$env = $_ENV['APP_ENV'] ?? 'production';

// Base configuration
$config = [
    // Application Settings
    'app' => [
        'name' => $_ENV['APP_NAME'] ?? 'PHP MVC Boilerplate',
        'env' => $env,
        'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
        'url' => $_ENV['APP_URL'] ?? 'http://localhost',
        'key' => $_ENV['APP_KEY'] ?? 'your-32-character-secret-key-here',
    ],

    // Database Configuration
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
        'dbname' => $_ENV['DB_DATABASE'] ?? 'myapp',
        'username' => $_ENV['DB_USERNAME'] ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],

    // Session Configuration
    'session' => [
        'lifetime' => (int) ($_ENV['SESSION_LIFETIME'] ?? 120),
        'secure' => $env === 'production',
        'httponly' => true,
        'samesite' => 'Strict',
    ],

    // Logging Configuration
    'logging' => [
        'level' => $_ENV['LOG_LEVEL'] ?? 'debug',
        'channel' => $_ENV['LOG_CHANNEL'] ?? 'single',
        'path' => __DIR__ . '/../storage/logs/app.log',
    ],

    // Security Configuration
    'security' => [
        'hash_algo' => $_ENV['HASH_ALGO'] ?? PASSWORD_DEFAULT,
        'csrf_token_name' => 'csrf_token',
        'csrf_expire' => 3600,
    ],
];

// Environment-specific overrides
if ($env === 'development') {
    $config['app']['debug'] = true;
    $config['session']['secure'] = false;
    $config['session']['lifetime'] = 1440; // 24 hours in development
    $config['logging']['level'] = 'debug';
} elseif ($env === 'production') {
    $config['app']['debug'] = false;
    $config['session']['secure'] = true;
    $config['session']['lifetime'] = 120; // 2 hours in production
    $config['logging']['level'] = 'error';
} elseif ($env === 'testing') {
    $config['app']['debug'] = true;
    $config['database']['dbname'] = 'testing_' . $config['database']['dbname'];
    $config['session']['secure'] = false;
    $config['logging']['level'] = 'debug';
}

return $config;