<?php

/**
 * File Name: /notes/update.php
 *
 * Description:  Handles the creation and storage of a new note. Validates the input.
 *      Checks for errors, and saves the note to the database if valid.
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-20
 */

use Core\App;
use Core\Database;
use Core\Validator;

// * Retrieves an instance of the `Database` class using the application's service container
$db = App::resolve(Database::class);

$currentUserId = 3;

// Retrieves the note associated with the provided `id` from the database. If the note is not found,
// the `findOrFail()` method throws an exception.
$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_POST['id']
])->findOrFail();

// check if user is authorized to edit the note
authorize($note['user_id'] === $currentUserId);

$errors = [];

// Validates the `body` field in the incoming POST request:
//  - It must be a string.
//  - It must be between 1 and 1200 characters.
// *
// If validation fails, an error message is added to the `$errors` array.
if (!Validator::string($_POST['body'], 1, 1200)) {
    $errors['body'] = "Text in the Note body is required and is not to exceed 1200 characters.";
}

// If there are validation errors, the function renders the `edit` view and passes the errors
// along with the original note data to the user for correction.
if (count($errors)) {
    return view('notes/edit.view.php', [
        'heading' => 'Edit Note',
        'errors' => $errors,
        'note' => $note
    ]) ;
}

// Executes an SQL query to update the `body` of the note in the `notes` table. The `id` and `body`
// parameters are passed securely to prevent SQL injection.
$db->query('UPDATE notes SET body = :bodywwwwwwwwwwwww WHERE id = :id', [
    'id' => $_POST['id'],
    'body' => $_POST['body']
]);

// redirect the user to the notes page
header('location: /notes');
die();