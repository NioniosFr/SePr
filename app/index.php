<?php

$redirect = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')) . '/www';

// Redirect the user to the right path.
header("Location:$redirect");
exit;