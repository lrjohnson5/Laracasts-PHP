<?php

declare(strict_types=1);

/**
 * File Name: VerifyCsrfToken.php
 * Description: Simple CSRF token verification
 * Author: PHP MVC Boilerplate
 * Created: 2025-07-14
 */

namespace Core\Middleware;

class VerifyCsrfToken
{
    public function handle(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Only check CSRF for state-changing methods
        if (!in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return;
        }

        $token = $_POST['csrf_token'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';

        if (empty($token) || empty($sessionToken) || !hash_equals($sessionToken, $token)) {
            header('location: /');
            exit();
        }
    }
}
