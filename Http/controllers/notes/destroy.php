
<?php

use Core\App;
use Core\Database;

// Manually building up Database class
// $config = require base_path('config.php');
// $db = new Database($config['database']);

// Using a container for building up the Database class
// 'Database::class' evaluates to a string of the full namespace path to the class, e.g. 'Core\Database'
$db = App::resolve(Database::class);

$currentUserId = 3;

$note = $db->query('SELECT * FROM notes WHERE id = :id', [
    'id' => $_POST['id']
])->findOrFail();

authorize($note['user_id'] === $currentUserId);

// form was submitted; delete the current note
$db->query('DELETE FROM notes WHERE id = :id', [
    'id' => $_GET['id']
]);

header('location: /notes');
exit();