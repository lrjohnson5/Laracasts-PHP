<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Http\Forms\LoginForm;

// check if user already exists
$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();
if (! $form->validate($email, $password)) {
    return view('session/create.view.php', [
        'errors' => $form->errors()
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