<?php
if (! defined('CW'))
    exit('invalid access');

class View
{

    /**
     * Name of the view.
     *
     * Works as an identifier.
     *
     * @var string
     */
    var $view;

    /**
     * File name of the view to render.
     *
     * @var string
     */
    var $file;

    /**
     * The folder where the view files are in.
     *
     * @var unknown
     */
    var $folder;

    /**
     * Parameters to use inside the view file.
     *
     * @var array
     */
    var $params;

    /**
     * The active page to be highlighted on the menu bar.
     *
     * @var string
     */
    var $activePage;

    /**
     * A default view to render if non-existent views where setted.
     * Should be a file path to a view file that uses no parameters.
     *
     * @var string
     */
    private $defaultView;

    function __construct()
    {
        global $path;
        $this->view = 'default';
        $this->folder = 'default';
        $this->file = $path['views'] . $this->folder . '/index.php';
        $this->defaultView = $this->file;
        $this->params = array();
        $this->avtivePage = 'Home';
    }

    function __get($param)
    {
        return $this->$param;
    }

    function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    /**
     * Sets the view to output.
     *
     * @param string $domain
     *            The folder the view is in.
     * @param string $viewName
     *            The file to show.
     */
    function setView($viewName, $domain = '')
    {
        global $path;
        $this->folder = empty($domain) ? $this->folder : $domain;
        $this->file = $path['views'] . $this->folder . DS . $viewName . '.php';
        $this->view = $viewName;
        if (! $this->isSafe()) {
            $this->file = $this->defaultView;
            $this->view = 'default';
        }
    }

    /**
     * Renders the view files.
     */
    function render()
    {
        global $path, $www;
        /* Serve response */
        $layout = $path['layout'];
        include_once $layout . 'header.php';
        include_once $layout . 'content.php';
        include_once $layout . 'footer.php';
    }

    /**
     * Checks wether the view file requested exists.
     *
     * @return boolean
     */
    function isSafe()
    {
        global $path;
        return file_exists($path['views'] . $this->folder) && is_readable($this->file);
    }
}