<?php

declare(strict_types=1);

/**
 * File Name: Guest.php
 * Description: Ensures the user is a guest and not logged in.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 *  Updated: 2025-07-14 - Added strict types only
 */

namespace Core\Middleware;

class Guest
{
    public function handle():void
    {
        if ($_SESSION['user'] ?? false) {
            header('location: /');
            exit();
        }
    }
}