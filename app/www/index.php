<?php
define('CW', 1); // CW stands for : Corporate Wiki.
// Define static paths.
define('BASE', dirname(__DIR__) . '/');
define('ETC', BASE . 'etc/');
// Define the global config variables.
global $path, $www, $db, $view,$route, $error;
/* Include global functions and classes. */
require_once ETC . 'bootstrap.php';

/* Dispatch request */
$route->determineRequest();
$route->execute();
/* Define actions */
// TODO: Classes to determine and define actions
/* Execute request */
// TODO: Classes to execute requests.
$view->render();
exit();

// Generally speaking:
// Find what was requested.
// Check for cookie/session.
// Find if the request is authenticated
// Determine and define actions.
// Do staff with data.
// Echo the response back to the requester.
