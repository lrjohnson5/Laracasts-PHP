<?php

declare(strict_types=1);

/**
 * File Name: Auth.php
 * Description: Ensures user authentication for accessing specific routes.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 *  Updated: 2025-07-14 - Added strict types only
 */

namespace Core\Middleware;

class Auth
{
    public function handle(): void {
        if (!($_SESSION['user'] ?? false)) {
            header('location: /');
            exit();
        }
    }
}