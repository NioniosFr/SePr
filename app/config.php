<?php
/**
 * Contains defines global variables used everywhere.
 * and classes that are essential for the application.
 */
if (! defined('CW'))
    exit('invalid access');

$server_base = 'localhost'; // $_SERVER['HTTP_HOST'] is NOT secure.
$request = $server_base . $_SERVER['SCRIPT_NAME'];
$protocol = ($_SERVER['SERVER_PROTOCOL'] == 'HTTPS') ? 'https://' : 'http://';
$base_url = substr($request, 0, strrpos($request, '/'));
$base_url = $protocol . $base_url;
$folder = substr($base_url, strrpos($base_url, '/') + 1);

define('BASEURL', $base_url);
define('WEBURL', ($folder === 'www') ? $base_url : $base_url . '/www');
