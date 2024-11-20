<?php

/**
 * File Name: index.php
 *
 * Description: Main entry point for the application.
 *      Initializes the application, sets up necessary configurations,
 *      and routes requests to the appropriate controller.
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

use Core\Session;
use Core\ValidationException;

const BASE_PATH = __DIR__ . '/../';

// Load Composer's autoload file to enable autoloading of dependencies
require BASE_PATH . '/vendor/autoload.php';

// Starts a new session or resumes an existing session
session_start();

// Include app helper functions
require BASE_PATH . 'Core/functions.php';

// Initialize application, set up configurations, prepare dependency injections
require base_path('bootstrap.php');

// Creates a new instance of the Router class to map URLs to appropriate controllers
$router = new \Core\Router();

// Imports route definitions which map URL patterns to their corresponding controllers/actions
$routes = require base_path('routes.php');

// Extracts request URI path from server's request data
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// identifies HTTP request method (GET, POST, etc.)
// use '_method' if present in the POST data
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
// above line is equivalent to below line
// $method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];

// Handles routing of requests with error handling
try {
    $router->route($uri, $method);
} catch (ValidationException $exception) {
    // Catches validation exceptions and stores error and old input data in session
    Session::flash('errors', $exception->errors);
    Session::flash('old', $exception->old);

    // Redirect user to previous URL to show validation errors
    return redirect($router->previousUrl());
}

// Clears any session-based flash messages
Session::unflash();
