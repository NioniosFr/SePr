<?php
/**
 * The only directly accessible file of this application.
 * Starts the application and serves the user requests.
 */

/**
 * Security variable.
 * Has to be checked at the top of every file to avoid direct access.
 *
 * @var boolean
 */
define('CW', 1); // CW stands for : Corporate Wiki.
if (! defined('DS')) {
    /**
     * Assigns a smaller identifier for the PHP built in DIRECTORY_SEPERATOR.
     *
     * @var string
     */
    define('DS', DIRECTORY_SEPARATOR);
}
/**
 * The file path to the root of this application.
 *
 * @var string A file path
 */
define('BASE', dirname(__DIR__) . DS);
/**
 * The file path to the folder containing the configuration files.
 *
 * @var string A file path
 */
define('ETC', BASE . 'etc' . DS);

// Define the global variables.
global $path, $www, $db, $session, $view;
/* Include global functions and classes. */
require_once ETC . 'bootstrap.php';

$route = get_route();
$route->determineRequest();
$route->executeController();
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
