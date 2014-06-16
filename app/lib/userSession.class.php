<?php
if (! defined('CW'))
    exit('invalid access');

class userSession
{

    /**
     * The session id.
     *
     * @var numeric
     */
    var $id;

    /**
     * The date the session started in unix format.
     *
     * @var numeric
     */
    var $started;

    /**
     * The name of the session.
     * Not really used anywhere except the cookie??
     *
     * @var string
     */
    var $name;

    /**
     * Logged in bit.
     *
     * @var boolean
     */
    var $loggedIn;

    /**
     * OneTimeUseNumber.
     *
     * A unique ID generated for every request.
     * it is checked for validity with the previous one on every request.
     *
     * @var number
     */
    var $otun;

    /**
     * The cookie variables that where read from the cookie.
     * Variables defined here will be placed inside the cookie.
     * The $_COOKIE array is not used.
     *
     * @var unknown
     */
    var $cookie;

    /**
     * The users username, If user is logged in and valid.
     *
     * @var string
     */
    var $user;

    function __construct()
    {
        session_start();
        $this->init();
        /**
         * Variables used to output information to the user.
         *
         * They are initialized and used during an app lifecycle.
         * Should be removed on every new request.
         */
        if (isset($_SESSION['NOTICE'])) {
            unset($_SESSION['NOTICE']);
        }
        if (isset($_SESSION['SUCCESS'])) {
            unset($_SESSION['SUCCESS']);
        }
    }

    /**
     * Initializes the session.
     * If user is loggedin the cookie variable wil be checked for the otun number.
     * Looks for the user with that otun in the database and retrieves the name only
     * if otun was updated during the last 15 minutes.
     *
     * Otherwise logges out the user or the registered otun and resets the session.
     */
    function init()
    {
        global $db;
        $this->id = $_SESSION['ID'] = (isset($_SESSION['ID'])) ? session_id($_SESSION['ID']) : session_id();
        $this->started = $_SESSION['STARTED'] = (isset($_SESSION['STARTED'])) ? $_SESSION['STARTED'] : time();
        $this->name = $_SESSION['NAME'] = (isset($_SESSION['NAME'])) ? $_SESSION['NAME'] : 'Guest';
        $this->otun = isset($_SESSION['OTUN']) ? $_SESSION['OTUN'] : null;

        if (isset($_COOKIE['user'])) {
            $this->getCookieVars();
            if (isset($this->cookie['otun'])) {
                if ($this->cookie['otun'] === $this->otun) {
                    $this->user = $this->dbOtunMatchesUser();
                    if ($this->user) {
                        $this->updateOtun();
                        $this->sessionCookieSave();
                        $this->loggedIn = true;
                        $this->userPermissions = $this->getUserPermissions($this->user);
                        return;
                    }
                }
            }
            $this->logout($this->otun);
            if (isset($this->cookie['otun'])) {
                $this->logout($this->cookie['otun']);
            }
            $this->resetSession();
        }
    }

    /**
     * Reads the cookie variables into the $this->cookie variable.
     */
    function getCookieVars()
    {
        $this->cookie = array();

        $args = explode(';', $_COOKIE['user']);
        array_map('htmlspecialchars', $args);
        foreach ($args as $var) {
            $var = explode('=', $var);
            if (isset($var[0]) && isset($var[1])) {
                $this->cookie[$var[0]] = $var[1];
            }
        }
    }

    /**
     * Creates and registers an otun number to the database for a given user.
     * This function should only be called once the user logs in.
     *
     * @param string $user
     *            The users username.
     */
    function createOtun($user)
    {
        global $db;
        $this->cookie['otun'] = $this->otun = $_SESSION['OTUN'] = md5(sprintf("%s%s", time(), $_SESSION['ID']));
        $db->execute("INSERT INTO `otun`(`user_name`,`otun`,`created`) VALUES (%s,%s,%s) ON DUPLICATE KEY UPDATE `otun`=%s;", array(
            $user,
            $this->otun,
            date('Y-m-d H:i:s'),
            $this->otun
        ));
    }

    /**
     * Updates the otun number and the modified time of an already logged in user.
     */
    function updateOtun()
    {
        global $db;
        $this->cookie['otun'] = $this->otun = $_SESSION['OTUN'] = md5(sprintf("%s%s", time(), $_SESSION['ID']));
        return $db->execute("UPDATE `otun` SET `otun` = %s, `modified`= %s WHERE `user_name`= %s;", array(
            $this->otun,
            date('Y-m-d H:i:s'),
            $this->user
        ));
    }

    /**
     * Checks whether a user with the given initialised otun exists.
     * If a user exists, the timeout interval of his last action will be checked and
     * if within limits the user name will be returned.
     *
     * If the timeout limit is exceded, the user is loged out.
     *
     * @return string boolean user_name of the user, false if not logged in, invalid otun or timedout session.
     */
    function dbOtunMatchesUser()
    {
        global $db;
        $res = $db->select("SELECT `user_name` FROM `otun` WHERE `otun` = %s;", array(
            $this->otun
        ));

        // Check that a user with that otun exists.
        if (isset($res['user_name'])) {
            // Get the last time the user accessed the website.
            $valid = $db->select("SELECT `modified` FROM `otun` WHERE `user_name` = %s;", array(
                $res['user_name']
            ));
            // Get the time difference of the last access to now.
            $timeDiff = time() - strtotime($valid['modified']);
            // Check the difference to be within the permitted limits.
            if ($timeDiff < time() - 1500) {
                return $res['user_name'];
            } else {
                Error::setError('Your session has expired.', 'Session timed out', 130);
                $this->logoutUser($res['user_name']);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Getter.
     *
     * @param string $property
     *            The variables name.
     * @return NULL | mixed Null if the variable doesn't exist or not set, the variable otherwise.
     */
    function __get($property)
    {
        return isset($this->$property) ? $this->property : null;
    }

    /**
     * Setter.
     *
     * Initializes a variable with a given name and value.
     * Also stores it in the global session array with a capitilized key.
     *
     * @param string $key
     *            The variable|key name.
     * @param mixed $value
     *            The value to set to the variable|key.
     */
    function __set($key, $value)
    {
        $this->$key = $_SESSION[strtoupper($key)] = $value;
    }

    /**
     * Deletes an initialized variable from the class and the global session array.
     *
     * @param string $key
     *            The variables name.
     */
    function remove($key)
    {
        if (isset($this->{$key})) {
            unset($this->{$key}, $_SESSION[strtoupper($key)]);
        }
    }

    /**
     * Sends a cookie to the user in the form of 'key=value' seperated with ';'
     * If $this->cookie is initialized, it will send those variables,
     * otherwise it will send the defaults (name and otun).
     *
     * The cookie lasts for an hour.
     */
    function sessionCookieSave()
    {
        if (! empty($this->cookie)) {
            $cookie = array();
            foreach ($this->cookie as $key => $value) {
                $cookie[$key] = htmlspecialchars($key . '=' . $value);
            }
            setcookie('user', implode(';', $cookie), time() + 3600, '/');
        } else {
            setcookie('user', implode(';', array(
                'otun=' . $this->otun,
                'name=' . $this->name
            )), time() + 3600, '/');
        }
    }

    /**
     * Deletes a cookie that has been send to the user and unsets the global $_COOKIE variable.
     */
    function sessionCookieDelete()
    {
        setcookie('user', '', time() - 60000, '/');
        unset($_COOKIE);
    }

    /**
     * Logs out a user with a given otun number.
     * If the user exists: will be deleted, otherwise no action will happen.
     *
     * @param string $otun
     *            The otun of the user.
     */
    function logout($otun)
    {
        global $db;
        $otun = db_escape_string($otun);
        $db->execute("DELETE FROM `otun` WHERE `otun`= %s;", array(
            $otun
        ));
        $this->loggedIn = false;
        $this->name = 'Guest';
    }

    /**
     * Logs out a user with a given user name.
     * If no user with that user name exists, no actions are taken.
     *
     * @param unknown $userName
     */
    function logoutUser($userName)
    {
        global $db;
        $db->execute("DELETE FROM `otun` WHERE `user_name`= %s;", array(
            $userName
        ));
        $this->loggedIn = false;
        $this->name = 'Guest';
    }

    /**
     * Retrieves all the permissions for a given user and returns them as an array(key=>value).
     *
     * @param string $user
     *            A username
     * @return NULL array If no user with that name null, otherwise a key=>value array.
     */
    function getUserPermissions($user)
    {
        global $db;
        $res = $db->select("SELECT * FROM `permissions` WHERE `user_name` = %s;", array(
            $user
        ));
        if ($res == null || count($res) <= 0) {
            return null;
        } else {
            return $res;
        }
    }

    /**
     * Resets the current session.
     *
     * Removes all cookie variables,
     * Deletes the cookie that was sent to the user,
     * Logs out a loged in user if any.
     * Restarts the service.
     */
    function resetSession()
    {
        session_destroy();
        $this->sessionCookieDelete();
        $this->loggedIn = false;
        $this->cookie = null;
        $this->init();
    }
}
