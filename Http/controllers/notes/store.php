<?php

/**
 * File Name: /notes/store.php
 *
 * Description:  Handles the creation and storage of a new note. Validates the input.
 *      Checks for errors, and saves the note to the database if valid.
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-20
 */

use Core\App;
use Core\Validator;
use Core\Database;

// Retrieves an instance of the `Database` class using the application's service container.
$db = App::resolve(Database::class);

$errors = [];

// Checks if the `body` field in the incoming POST request meets the required conditions:
//  - It must be a string.
//  - It must be between 1 and 1200 characters.
//
// If validation fails, an error message is added to the `$errors` array.
if (!Validator::string($_POST['body'], 1, 1200)) {
    $errors['body'] = "Text in the Note body is required and is not to exceed 1200 characters.";
}

// If the `$errors` array is not empty, the function renders the `create` view, passing the
// errors back to the user
if (! empty($errors)) {
    return view("notes/create.view.php", [
        'heading' => 'Create a Note',
        'errors' => $errors,
    ]);
}

// Executes an SQL query to insert the new note into the `notes` table. The note's body and
// the `user_id` of the currently authenticated user are provided as parameters.
$db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
    ':body' => $_POST['body'],
    ':user_id' => 3
]);

// Redirects to the notes page
header('Location: /notes');
die();