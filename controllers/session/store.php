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

if (!Validator::string($password)) {
    $errors['password'] = "Password must be a valid match.";
}

if (! empty($errors)) {
    return view('session/create.view.php', [
        'errors' => $errors
    ]);
}

// match user credentials
$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($user) {
    // have a user, now make sure password matches
    if (password_verify($password, $user['password'])) {
        login([
            'email' => $email
        ]);

        header('location: /');
        exit();
    }
}

return view('session/create.view.php', [
    'errors' => [
        'email' => 'No matching account found for given email address and password.'
    ]
]);