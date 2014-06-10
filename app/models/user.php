<?php
global $path;
require_once $path['lib'] . 'dbHandler.class.php';
require_once $path['lib'] . 'userSession.class.php';

class UserModel
{

    /**
     * Validate that the user credentials where correct.
     *
     * @param string $name
     * @param pass $pass
     */
    function checkUserCredentials($name, $pass)
    {
        global $db;
        $userExists = $db->select(sprintf("SELECT * FROM `user_auth` WHERE `email_address` = '%s' AND `passw` = sha2('%s', 256);", $name, $pass));
        if ($userExists == null || count($userExists) === 0) {
            return false;
        } else {
            return true;
        }
    }
}
