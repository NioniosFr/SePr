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

    private $db_con;

    function __construct($args)
    {
        $this->db_host = $args['host'];
        $this->db_port = $args['port'];
        $this->db_name = $args['name'];
        $this->db_username = $args['username'];
        $this->db_password = $args['password'];
        $this->db_con = null;
    }

    private function open()
    {
        try {
            $this->db_con = mysql_connect($this->db_host . ':' . $this->db_port, $this->db_username, $this->db_password);
        } catch (Exception $e) {
            return null;
        }
    }

    private function close()
    {
        try {
            mysql_close($this->db_con);
        } catch (Exception $e) {
            return null;
        }
    }

    public function select($query, $params)
    {
        $this->open();
        try {
            mysql_select_db($this->db_name, $this->db_con) or die("ERROR: " . mysql_errno() . " - " . mysql_error());
            ;
        } catch (Exception $e) {
            $this->close();
            return false;
        }
        //$query = mysql_real_escape_string($query);
        $result = mysql_query($query, $this->db_con) or die("ERROR: " . mysql_errno() . " - " . mysql_error() . ' - ' . var_dump($query));
        $rows = mysql_fetch_array($result);
        $this->close();
        return $rows;
    }

    public function insert()
    {}

    public function update()
    {}

    public function delete()
    {}
}