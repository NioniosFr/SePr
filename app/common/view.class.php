<?php
if (! defined('CW'))
    exit('invalid access');

class View{

    var $view;
    var $file;
    var $params;

	function __construct()
	{
        $this->view = '';
        $this->file = '';
        $this->params = array();
	}

	function __get($param)
	{
        return $this->$param;
	}

	function render()
	{
	    global $path, $www;
	    /* Serve response */
	    $layout = $path['layout'];
	    include_once $layout . 'header.php';
	    include_once $layout . 'content.php';
	    include_once $layout . 'footer.php';
	}

	function isSafe()
	{
		return is_readable($this->file) && file_exists($path['views'].$this->view);
	}
}