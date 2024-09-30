<?php

use Core\App;
use Core\Database;
use Core\Validator;

// check if user already exists
$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

// validate form inputs
$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = "Please proved a valid email address.";
}

if (!Validator::string($password, 8, 255)) {
    $errors['password'] = "Password must be at least 8 characters long.";
}

if (! empty($errors)) {
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}

$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($user) {
    // if yes, redirect to login page
    header('location: /');
    exit();
} else {
    // if no, save new user to the database, log new user in, redirect
    $db->query('INSERT INTO users (email, password) VALUES (:email, :password)', [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    login($user);

    header('location: /');
    exit();
}