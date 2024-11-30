<?php

/**
 * File Name: /notes/delete.php
 *
 * Description: Routes to delete note view if note exists and user authorized
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-20
 */

use Core\App;
use Core\Database;

// Retrieves an instance of the `Database` class using the application's service container.
// This allows the application to use dependency injection to build and provide the database instance.
$db = App::resolve(Database::class);

// Queries the database to fetch the details of the note being edited.
// The `findOrFail()` method ensures that an exception is thrown if no
// matching note is found.
$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_GET['id']
])->findOrFail();

// Ensures that the current user is authorized to edit the note.
authorize($note['user_id'] === $_SESSION['user']['user_id']);

// * Passes the note details to the delete view for rendering.
view("notes/delete.view.php", [
    'heading' => 'Delete a Note',
    'errors' => [],
    'note' => $note
]);