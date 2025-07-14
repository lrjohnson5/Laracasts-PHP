<?php

declare(strict_types=1);

/**
 * File Name: EmailConfirmed.php
 * Description: Checks if email address has been confirmed.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 *  Updated: 2025-07-14 - Added basic implementation
 */

namespace Core\Middleware;

class EmailConfirmed
{
    public function handle(): void
    {
        // For now, just check if user exists and is logged in
        // You can enhance this later when you have email verification
        if (!($_SESSION['user'] ?? false)) {
            header('location: /');
            exit();
        }

        // TODO: Add actual email verification check when needed
        // Example: Check if $_SESSION['user']['email_verified'] is true
    }
}
