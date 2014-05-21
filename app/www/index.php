<?php
define ( 'CW', 1 );

define ( 'BASE', dirname ( __DIR__ ) . '/' );
define ( 'LIB', BASE . 'libraries/' );
define ( 'WEB', dirname ( __FILE__ ) );
define ( 'TEMPLATES', BASE . 'templates/' );

/* Include composers autoload. */
include_once dirname ( dirname ( BASE ) ) . '/vendor/autoload.php';
/* Include configuration files. */
include_once BASE . 'bootstrap.php';
include_once BASE . 'config.php';

/* Dispatch request */
// TODO: Classes to dispatch the request
/* Define actions */
// TODO: Classes to determine and define actions
/* Execute request */
// TODO: Classes to execute requests.
/* Serve response */
include_once TEMPLATES . 'header.php';
include_once TEMPLATES . 'content.php';
include_once TEMPLATES . 'footer.php';

// Generally speaking:
// Find what was requested.
// Check for cookie/session.
// Find if the request is authenticated
// Determine and define actions.
// Do staff with data.
// Echo the response back to the requester.
