
<?php

/**
 * File Name: /notes/show.php
 *
 * Description: Fetches requested note and passes to the show view
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-20
 */

use Core\App;
use Core\Database;

//  * Retrieves an instance of the `Database` class using the application's service container.
$db = App::resolve(Database::class);

$currentUserId = 3;

// Queries the database to fetch the details of a specific note, identified by the `id` parameter
// in the incoming GET request. The `findOrFail()` method ensures that an exception is thrown if no
// matching note is found.
$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_GET['id']
])->findOrFail();

// Ensures that the current user is authorized to view the note
authorize($note['user_id'] === $currentUserId);

// Passes the note details to the `show` view for rendering
view("notes/show.view.php", [
    'heading' => 'New Note',
    'note' => $note,
]);