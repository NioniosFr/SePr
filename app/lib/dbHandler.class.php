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
        try {
            if (empty($this->db_port)) {
                $this->db_con = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name);
            } else {
                $this->db_con = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name, $this->db_port);
            }
        } catch (Exception $e) {
            Error::setError(sprintf("%s", $e), 'DB Open connection error', 150);
            return null;
        }
        if (mysqli_connect_errno($this->db_con)) {
            Error::setError(sprintf("%s", $e), 'DB Open connection error', 150);
            return null;
        }
    }

    public function close()
    {
        try {
            mysqli_close($this->db_con); // or die("ERROR: " . mysql_errno() . " - " . mysql_error());
        } catch (Exception $e) {
            Error::setError(sprintf("%s", $e), 'DB Close connection error', 150);
            return null;
        }
    }

    /**
     * Perform a select query to the DB.
     *
     * @param string $query
     *            The select query to execute.
     *            If $data are passed, the query string has to be in the sprintf
     *            format, without quotes for the string values, these are added internally.
     * @param array $data
     *            [Recommended][Optional] The query parameters in order of apearence.
     * @return array|NULL An assosiative array.
     *         If single result is returned from DB: array(column=>value).
     *         If multiple results are returned: array([0]=>array(column=>value),...)
     *         On errors it returns null.
     */
    public function select($query, Array $data = null)
    {
        $this->open();
        if ($this->db_con == null) {
            return null;
        }

        try {
            if (isset($data[0])) {
                $query = dbvsprintf($query, $data, $this->db_con);
            }
            $res = mysqli_query($this->db_con, $query);
            $count = ($res->num_rows) ? $res->num_rows : 0;
            if ($count <= 1 && $res->field_count > 0) {
                $rows = mysqli_fetch_assoc($res);
            } else {
                $rows = array();
                while ($count > 0) {
                    $rows[] = mysqli_fetch_assoc($res);
                    $count --;
                }
            }
        } catch (Exception $e) {
            Error::setError(sprintf("%s", $e), 'DB select query error', 150);
            $this->close();
            return null;
        }
        $this->close();
        return $rows;
    }

    public function insert($query)
    {
        $this->open();
        try {
            $res = mysqli_query($this->db_con, $query);
        } catch (Exception $e) {
            Error::setError(sprintf("%s", $e), 'DB update query error', 150);
            $this->close();
            return false;
        }
        if (! $res) {
            Error::setError(sprintf("%s", ''), 'DB update query error', 150);
        }
        $this->close();
        return ($res == null) ? false : $res;
    }

    /**
     * Perform an update command to the DB.
     *
     * @param string $query
     *            The query to execute.
     * @return boolean True in success, False if failed or errored.
     */
    public function update($query)
    {
        $this->open();
        try {
            $res = mysqli_query($this->db_con, $query);
        } catch (Exception $e) {
            Error::setError(sprintf("%s", $e), 'DB update query error', 150);
            $this->close();
            return false;
        }
        $this->close();
        return ($res == null) ? false : $res;
    }

    /**
     * Perform a delete query to the database.
     *
     * @param string $query
     *            The query to execute.
     * @return boolean True in success, False if failed or errored.
     */
    public function delete($query)
    {
        $this->open();
        try {
            $res = mysqli_query($this->db_con, $query);
        } catch (Exception $e) {
            Error::setError(sprintf("%s", $e), 'DB delete query error', 150);
            $this->close();
            return false;
        }
        $this->close();
        return ($res == null) ? false : $res;
    }

    /**
     * Perform an INSERT|UPDATE|DELETE command to the database.
     *
     * @param string $query
     *            The query to execute. | If $params are passed, the query has to be in sprintf format.
     *            For convenience it will quote the %20 for you. SO don't do ti yourself
     * @param array $data
     *            [Recommended][Optional] The parameters in order of appearence inside the query.
     * @return boolean True in success, False if failed or errored.
     */
    public function execute($query, Array $data = null)
    {
        $this->open();
        try {
            if (isset($data[0])) {
                $query = dbvsprintf($query, $data, $this->db_con);
            }
            $res = mysqli_query($this->db_con, $query);
        } catch (Exception $e) {
            Error::setError(sprintf("%s", $e), 'DB query failed.');
            $this->close();
            return false;
        }
        $this->close();
        return ($res == null) ? false : $res;
    }
}
