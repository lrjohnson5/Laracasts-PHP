<?php

/**
 * File Name: Authenticator.php
 * Description: Manages user authentication.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

namespace Core;

class Authenticator
{
    public function attempt($email, $password) {
        $user = App::resolve(Database::class)
            ->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            // have a user, now make sure password matches
            if (password_verify($password, $user['password'])) {
                $this->login([
                    'email' => $email
                ]);

                return true;
            }
        }

        return false;
    }


    public function login($user) {
        // mark current user as logged-in
        $_SESSION['user'] = [
            'email' => $user['email']
        ];

        session_regenerate_id(true);
    }

    public function logout() {
        Session::destroy();
    }
}