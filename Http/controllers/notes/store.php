<?php

use Core\App;
use Core\Validator;
use Core\Database;


$db = App::resolve(Database::class);

$errors = [];

if (!Validator::string($_POST['body'], 1, 1200)) {
    $errors['body'] = "Text in the Note body is required and is not to exceed 1200 characters.";
}

if (! empty($errors)) {
    return view("notes/create.view.php", [
        'heading' => 'Create a Note',
        'errors' => $errors,
    ]);
}

$db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
    ':body' => $_POST['body'],
    ':user_id' => 3
]);

header('Location: /notes');
die();