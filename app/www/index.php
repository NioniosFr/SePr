<?php
define('CW', 1); // CW stands for : Corporate Wiki.
if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
// Define static paths.
define('BASE', dirname(__DIR__) . DS);
define('ETC', BASE . 'etc' . DS);
// Define the global variables.
global $path, $www, $db, $session, $view, $route;
/* Include global functions and classes. */
require_once ETC . 'bootstrap.php';

$route->determineRequest();
$route->finalCheck();
$view->render();
exit();

// Generally speaking:
// Find what was requested.
// Check for cookie/session.
// Find if the request is authenticated
// Determine and define actions.
// Do staff with data.
// Echo the response back to the requester.
