
<?php

/**
 * File Name: /notes/destroy.php
 *
 * Description: Deletes note for authorized users
 *      Redirects to notes listing
 *
 * Author: Laracasts.com
 * Created Date: 2024-11-20
 */

use Core\App;
use Core\Database;

// Manually building up Database class
// $config = require base_path('config.php');
// $db = new Database($config['database']);

// Using a container for building up the Database class
// 'Database::class' evaluates to a string of the full namespace path to the class, e.g. 'Core\Database'
$db = App::resolve(Database::class);

// Queries the database to fetch the details of the note being deleted.
// The `findOrFail()` method ensures that an exception is thrown if no
// matching note is found.
$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_POST['id']
])->findOrFail();

// Ensures that the current user is authorized to delete the note.
authorize($note['user_id'] === $_SESSION['user']['user_id']);

// form was submitted; delete the current note
// needs an exception case
$db->query('DELETE FROM notes WHERE id = :id', [
    'id' => $_POST['id']
]);

// Redirect to notes list
header('location: /notes');
exit();