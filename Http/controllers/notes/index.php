
<?php

/**
 * File Name: /notes/index.php
 *
 * Description: Fetches & displays all notes belonging to the currently
 *      authorized user; passes to the notes view
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-20
 */

use Core\App;
use Core\Database;

// Retrieves an instance of the `Database` class using the application's service container.
// This enables dependency injection to handle the database connection and operations.
$db = App::resolve(Database::class);

// Executes a query to fetch all notes associated with the currently authenticated user.
$notes = $db->query('SELECT * FROM notes WHERE user_id = :id', ['id' => $_SESSION['user']['user_id']])->get();

// Passes the list of notes and page heading to the index view for rendering.
view("notes/index.view.php", [
    'heading' => 'My Notes',
    'notes' => $notes,
]);