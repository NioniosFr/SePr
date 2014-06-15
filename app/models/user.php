<?php
if (! defined('CW'))
    exit('invalid access');

global $path;
require_once $path['lib'] . 'dbHandler.class.php';
require_once $path['lib'] . 'userSession.class.php';

class UserModel
{

    /**
     * Validate that the user credentials where correct.
     *
     * @param string $mail
     * @param pass $pass
     */
    function checkUserCredentials($mail, $pass)
    {
        global $db;
        $userExists = $db->select(sprintf("SELECT COUNT(*) FROM `user_auth` WHERE `email_address` = '%s' AND `passw` = sha2('%s', 256);", $mail, $pass));

        if ($userExists == null || count($userExists) === 0) {
            return false;
        } else {
            return true;
        }
    }

    function getUserName($mail)
    {
        global $db;
        $res = $db->select(sprintf("SELECT `user_name` FROM `user_auth` WHERE `email_address` = '%s';", $mail));

        if (isset($res)) {
            return $res['user_name'];
        } else {
            return null;
        }
    }

    function getUserEmail($userName)
    {
        global $db;
        $res = $db->select(sprintf("SELECT `email_address` FROM `user_auth` WHERE `user_name` = '%s';", $userName));

        if (isset($res)) {
            return $res['email_address'];
        } else {
            return null;
        }
    }

    function logout($user)
    {
        global $db;
        $db->select(sprintf("DELETE FROM `otun` WHERE `user_name` = '%s';", mysql_escape_string($user)));
    }

    /**
     * Queries the database and retrieves all the pages where last editor is the loggedIn user.
     */
    function getPagesEdited($userName)
    {
        global $db;
        $res = $db->select(sprintf("SELECT * FROM `page` WHERE `last_edited_by` = '%s';", $userName));
        return $res;
    }
}
