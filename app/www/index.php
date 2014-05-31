<?php
define('CW', 1); // CW stands for : Corporate Wiki.

// Define static paths.
define('BASE', dirname(__DIR__) . '/');
define('ETC', BASE . 'etc/');
define('CMN', BASE . 'common/');
/* Include global functions */
require_once CMN . 'functions.php';
/* Include configuration files. */
require_once CMN . 'bootstrap.php';

/* Dispatch request */
// TODO: Classes to dispatch the request
/* Define actions */
// TODO: Classes to determine and define actions
/* Execute request */
// TODO: Classes to execute requests.

/* Serve response */
$layout = BASE . $config['PATHS']['layout'];
include_once $layout . 'header.php';
include_once $layout . 'content.php';
include_once $layout . 'footer.php';

// Generally speaking:
// Find what was requested.
// Check for cookie/session.
// Find if the request is authenticated
// Determine and define actions.
// Do staff with data.
// Echo the response back to the requester.
