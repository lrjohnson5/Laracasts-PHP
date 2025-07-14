<?php

namespace Http\Controllers\Session;

use Core\Authenticator;

$auth = new Authenticator;

$auth->logout();

header('location: /');
exit();