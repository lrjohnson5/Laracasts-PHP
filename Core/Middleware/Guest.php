<?php

/**
 * File Name: Guest.php
 * Description: Ensures the user is a guest and not logged in.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core\Middleware;

class Guest
{
    public function handle() {
        if ($_SESSION['user'] ?? false) {
            header('location: /');
        }
    }
}