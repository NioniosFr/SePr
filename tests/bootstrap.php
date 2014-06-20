<?php
/**
 * Defines the GLOBAL variable used throughout the app for convenience.
 *
 * @todo: Write tests for these variables.
 */
define('DS', DIRECTORY_SEPARATOR);
define('CW', 1);
define('BASE', dirname(__DIR__) . DS . 'app' . DS);
define('ETC', BASE . 'etc' . DS);
$config = parse_ini_file(ETC . 'config.ini.php', true);

require_once BASE . $config['PATH']['common'] . DS . 'functions.php';

global $path, $www;
$path['PATH'] = fix_config_paths($config['PATH']);
$config['WWW']['base'] = 'wwwBase';
$config['WWW']['web'] = 'wwwWeb';
$config['WWW']['rsrcs'] = 'resources';
$config['WWW']['scripts'] = 'scripts';
$config['WWW']['styles'] = 'styles';

class Error
{

    static function setError()
    {}

    static function hasError()
    {}

    static function severErrorOccured()
    {}
}
