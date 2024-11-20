<?php

/**
 * File Name: /registration/store.php
 *
 * Description: Handles the creation of new user accounts. Validates input, checks for existing users,
 *  saves new users to the database, logs them in, and redirects to the homepage.
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-20
 */

use Core\App;
use Core\Authenticator;
use Core\Database;
use Core\Validator;

// Retrieves an instance of the `Database` class using the application's service container
$db = App::resolve(Database::class);


// Validates email and password from the incoming POST request and validates them:
// * - The email must be in a valid format.
// * - The password must be between 8 and 255 characters.
$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = "Please proved a valid email address.";
}

if (!Validator::string($password, 8, 255)) {
    $errors['password'] = "Password must be at least 8 characters long.";
}

// If there are validation errors, re-render the registration form with error messages.
if (! empty($errors)) {
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}

// Queries the database to check if a user with the given email already exists.
// If a user is found, redirects the user to the login page.
$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($user) {
    // if exists, redirect to login page
    header('location: /');
    exit();
} else {
    // if not, save new user to the database, log new user in, redirect
    $db->query('INSERT INTO users (email, password) VALUES (:email, :password)', [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    // Creates an authenticated session for the new user using the `Authenticator` class.
    $auth = new Authenticator;
    $auth->login(['email' => $email]);

    // Redirect to homepage after successful registration and login
    header('location: /');
    exit();
}