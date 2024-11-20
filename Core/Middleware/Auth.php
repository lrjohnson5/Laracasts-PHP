<?php

/**
 * File Name: Auth.php
 * Description: Ensures user authentication for accessing specific routes.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core\Middleware;

class Auth
{
    public function handle() {
        if (! $_SESSION['user'] ?? false) {
            header('location: /');
        }
    }
}