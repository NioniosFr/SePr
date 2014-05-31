<?php
if (! defined('CW'))
    exit('invalid access');

    /* Include composers autoload. */
$composer = dirname(dirname(BASE)) . '/vendor/autoload.php';
if (file_exists($composer))
    require_once $composer;

    // Define the global config variable.
global $config;
// Read it from the ini file.
$config = parse_ini_file(ETC . 'config.ini.php', true);
$config['PATHS'] = fix_config_paths($config['PATHS']);
// Get the file that was accessed from the server.
$request = $config['WWW']['server'] . $_SERVER['SCRIPT_NAME'];
// Get the protocol used.
$config['WWW']['protocol'] = ($_SERVER['SERVER_PROTOCOL'] == 'HTTPS') ? 'https://' : 'http://';
// Figure out the base URI.
$config['WWW']['base'] = $config['WWW']['protocol'] . substr($request . $_SERVER['SCRIPT_NAME'], 0, strrpos($request, '/'));
// Extract the folder containing the script that was accessed.
$folder = substr($config['WWW']['base'], strrpos($config['WWW']['base'], '/')) + 1;
if ($folder == 'www') {
    $config['WWW']['web'] = $config['WWW']['base'];
    $config['WWW']['base'] = preg_replace("/$folder/", '', $config['WWW']['base']);
} else {
    $config['WWW']['web'] = $config['WWW']['base'] . '/www';
}
// Free unnecessary resources.
unset($folder, $composer, $request);
