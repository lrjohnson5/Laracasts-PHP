<?php

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

// building up the Database object
// associating a string, 'Core\Database' with a builder function
$container->bind('Core\Database', function () {
    $config = require base_path('config.php');
    return new Database($config['database']);
});

App::setContainer($container);