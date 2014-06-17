<?php
if (! defined('CW'))
    exit('invalid access');

    /* Include composers autoload. */
$composer = dirname(dirname(BASE)) . DS . 'vendor' . DS . 'autoload.php';
if (file_exists($composer))
    include_once $composer;

    // Read config from the ini file.
$config = parse_ini_file(ETC . 'config.ini.php', true);
/* Include the global functions. */
require_once BASE . $config['PATH']['common'] . DS . 'functions.php';

// Set error reporting.
if (isset($config['GENERAL']['debug']) && $config['GENERAL']['debug'] >= 1) {
    error_reporting(E_ALL | ~ E_STRICT);
} else {
    error_reporting(0);
}

// Set the time to Europe/Amsterdam (fixes the timeout on the iris.fhict server)
date_default_timezone_set("Europe/Amsterdam");

// Add trailing slashes and BASE to the paths.
$config['PATH'] = fix_config_paths($config['PATH']);
// Get the file that was accessed from the server.
$request = $config['WWW']['server'] . $_SERVER['SCRIPT_NAME'];
// Get the protocol used.
$config['WWW']['protocol'] = ($_SERVER['SERVER_PROTOCOL'] == 'HTTPS') ? 'https://' : 'http://';
// Figure out the base URI.
$config['WWW']['base'] = $config['WWW']['protocol'] . substr($request . $_SERVER['SCRIPT_NAME'], 0, strrpos($request, '/'));
// Extract the folder containing the script that was accessed.
$folder = substr($config['WWW']['base'], strrpos($config['WWW']['base'], '/') + 1);
if ($folder == 'www') {
    $config['WWW']['web'] = $config['WWW']['base'];
    $config['WWW']['base'] = preg_replace("/$folder/", '', $config['WWW']['base']);
} else {
    $config['WWW']['web'] = $config['WWW']['base'] . '/www';
}
$config['WWW']['rsrcs'] = $config['WWW']['web'] . '/' . $config['WWW']['rsrcs'] . '/';
$config['WWW']['scripts'] = $config['WWW']['web'] . '/' . $config['WWW']['scripts'] . '/';
$config['WWW']['styles'] = $config['WWW']['web'] . '/' . $config['WWW']['styles'] . '/';

// Define the global config variables.
global $path, $www, $db, $session, $view, $route, $error;
// Contains system paths to folders.
$path = $config['PATH'];
// Contains urls to folders.
$www = $config['WWW'];

// Require global classes.
include_once $path['common'] . 'route.class.php';
require_once $path['common'] . 'controller.class.php';
require_once $path['common'] . 'view.class.php';
require_once $path['common'] . 'error.class.php';
require_once $path['lib'] . 'dbHandler.class.php';
require_once $path['lib'] . 'userSession.class.php';
// Holds the route class for dispatching requests.
$route = new Route();
// Holds the view class to render.
$view = new View();
// Holds the errors that occur.
$error = new Error();
// Holds the database handler object.
$db = new DbHandler($config['DB']);
$session = new UserSession();
// Free unnecessary resources.
unset($folder, $composer, $request, $config);
