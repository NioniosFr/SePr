<?php
if (! defined('CW'))
    exit('invalid access');

class View{

    var $view;
    var $file;
    var $params;
    var $activePage;
    private $defaultView;

	function __construct()
	{
	    global $path;
        $this->view = 'default';
        $this->file = $path['views'].'login/index.php';
        $this->defaultView = $this->file;
        $this->params = array();
        $this->avtivePage = 'Home';
	}

	function __get($param)
	{
        return $this->$param;
	}

	function  __set($attr , $value)
	{
		$this->$attr = $value;
	}

	function setView($domain, $viewName)
	{
	    global $path;
        $this->file = $path['views'].$domain.'/'.$viewName.'.php';
        $this->view = $viewName;
        if (! file_exists($this->file)){
            $this->file = $this->defaultView;
            $this->view = $viewName;
        }
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