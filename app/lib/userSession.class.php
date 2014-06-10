<?php
if (! defined('CW'))
    exit('invalid access');

class userSession
{

    var $id;

    var $started;

    var $name;

    /**
     * OneTimeUseNumber.
     *
     * A unique ID generated for every request.
     * it is checked for validity with the previous one on every request.
     *
     * @var number
     */
    var $otun;

    function __construct()
    {
        session_start();
        $this->id = $_SESSION['ID'] = (isset($_SESSION['ID'])) ? session_id($_SESSION['ID']) : session_id();
        $this->started = $_SESSION['STARTED'] = (isset($_SESSION['STARTED'])) ? $_SESSION['STARTED'] : time();
        $this->name = $_SESSION['NAME'] = (isset($_SESSION['NAME'])) ? $_SESSION['NAME'] : 'Guest';
        $this->otun = $_SESSION['OTUN'] = md5(sprintf("%s%s", time(), $_SESSION['ID']));
    }

    function __get($property)
    {
        return $this->$property;
    }

    function __set($key, $value)
    {
        $this->$key = $_SESSION[strtoupper($key)] = $value;
    }

    function sessionCookieSave()
    {
        setcookie($this->name, $this->name, $this->otun, "/");
    }

    function resetSession()
    {
        session_start();
        $this->id = $_SESSION['ID'] = session_id();
        $this->started = $_SESSION['STARTED'] = time();
        $this->name = $_SESSION['NAME'] = 'Guest';
        $this->otun = $_SESSION['OTUN'] = md5(sprintf("%s%s", time(), $_SESSION['ID']));
    }
}
