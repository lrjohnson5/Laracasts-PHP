<?php

declare(strict_types=1);

/**
 * File Name: Authenticator.php
 * Description: Manages user authentication.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 * Updated: 2025-07-14 - Added strict types and security improvements
 */

namespace Core;

class Authenticator
{
    public function attempt(string $email, string $password): bool
    {
        $user = App::resolve(Database::class)
            ->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            // have a user, now make sure password matches
            if (password_verify($password, $user['password'])) {
                $this->login($user);

                return true;
            }
        }

        return false;
    }


    public function login(array $user): void
    {
        // mark current user as logged-in
        $_SESSION['user'] = [
            'email' => $user['email'],
            'user_id' => $user['id']
        ];

        session_regenerate_id(true);
    }

    public function logout(): void
    {
        Session::destroy();
    }

    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public function id(): ?int
    {
        return $_SESSION['user']['user_id'] ?? null;
    }
}