<?php
if (! defined('CW'))
    exit('invalid access');

class DbHandler
{

    private $db_host;

    private $db_port;

    private $db_name;

    private $db_username;

    private $db_password;

    public $db_con;

    function __construct($args)
    {
        $this->db_host = $args['host'];
        $this->db_port = $args['port'];
        $this->db_name = $args['name'];
        $this->db_username = $args['username'];
        $this->db_password = $args['password'];
        $this->db_con = null;
    }

    public function open()
    {
        global $error;
        try {
            if (empty($this->db_port)) {
                $this->db_con = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name);
            } else {
                $this->db_con = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name, $this->db_port);
            }
        } catch (Exception $e) {
            $error->errorOccured(sprintf("%s", $e), 'DB Open connection error', 150);
            return null;
        }
        if (mysqli_connect_errno($this->db_con)) {
            $error->errorOccured(sprintf("%s", $e), 'DB Open connection error', 150);
            return null;
        }
    }

    public function close()
    {
        global $error;
        try {
            mysqli_close($this->db_con); // or die("ERROR: " . mysql_errno() . " - " . mysql_error());
        } catch (Exception $e) {
            $error->errorOccured(sprintf("%s", $e), 'DB Close connection error', 150);
            return null;
        }
        if (mysqli_connect_errno($this->db_con)) {
            $error->errorOccured(sprintf("%s", $e), 'DB Close connection error', 150);
            return null;
        }
    }

    public function select($query, $params)
    {
        global $error;
        $this->open();
        try {
            $res = mysqli_query($this->db_con, $query);
            $count = $res->num_rows;
            if ($count <= 1 && $res->field_count > 0) {
                unset($rows);
                $rows = mysqli_fetch_assoc($res);
            } else {
                $rows = array();
                while ($count > 0) {
                    $rows[] = mysqli_fetch_assoc($res);
                    $count --;
                }
            }
        } catch (Exception $e) {
            $error->errorOccured(sprintf("%s", $e), 'DB select query error', 150);
            $this->close();
            return false;
        }
        // $result = mysql_query($query, $this->db_con); //or die("ERROR: " . mysql_errno() . " - " . mysql_error() . ' - ' . var_dump($query));
        // $rows = mysql_fetch_array($result);
        $this->close();
        return $rows;
    }

    public function insert($query)
    {
        global $error;
        $this->open();
        try {
            $res = mysqli_query($this->db_con, $query);
        } catch (Exception $e) {
            $error->errorOccured(sprintf("%s", $e), 'DB update query error', 150);
            $this->close();
            return false;
        }
        $this->close();
        return ($res == null) ? false : $res;
    }

    public function update($query)
    {
        global $error;
        $this->open();
        try {
            $res = mysqli_query($this->db_con, $query);
        } catch (Exception $e) {
            $error->errorOccured(sprintf("%s", $e), 'DB update query error', 150);
            $this->close();
            return false;
        }
        $this->close();
        return ($res == null) ? false : $res;
    }

    public function delete($query)
    {
        global $error;
        $this->open();
        try {
            $res = mysqli_query($this->db_con, $query);
        } catch (Exception $e) {
            $error->errorOccured(sprintf("%s", $e), 'DB delete query error', 150);
            $this->close();
            return false;
        }
        $this->close();
        return ($res == null) ? false : $res;
    }
}