<?php

/**
 * File Name: routes.php
 * Description: Defines route mappings for the app, associating URL paths with controllers.
 * Author: Laracasts.com
 * Created Date: 2024-11-08
 */

// Static Pages
$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

// Notes
$router->get('/notes', 'notes/index.php')->only('auth');
$router->get('/note', 'notes/show.php');

$router->get('/notes/create', 'notes/create.php');
$router->post('/notes', 'notes/store.php');

$router->get('/note/edit', 'notes/edit.php');
$router->patch('/note', 'notes/update.php');

$router->get('/note/delete', 'notes/delete.php');
$router->delete('/note', 'notes/destroy.php');

// User Registration
$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');
