<?php
if (! defined('CW'))
    exit('invalid access');

global $db;

$result = $db->select(sprintf("select * from user_auth where `passw` = sha2('%s',256)", 'password_testing'));
?>
<h2>Default view</h2>
