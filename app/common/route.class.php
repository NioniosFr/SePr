<?php
if (! defined('CW'))
    exit('invalid access');

global $path,$view, $error;

/**
 * Determines which request was asked by the user.
 *
 * @author nionios
 *
 */
class Route
{
    var $uri;
    var $query;
    var $request;
    var $controller;
    var $action;
    var $arguments;

    function __construct()
    {
        $this->uri = urldecode(rawurldecode($_SERVER['REQUEST_URI']));
        $this->query = $_SERVER['QUERY_STRING'];
        $this->request = $_REQUEST;
        $this->action = '';
        $this->arguments = array();
    }

    private function sanitizeRequest()
    {
        if (empty($this->request))
            return;
    }

    /**
     * Defaults on the default screen.
     * If a user is logged in he will still be logged in after a wrong route.
     */
    function determineRequest()
    {
        $this->getAction();

        switch ($this->action) {
            case 'login':
                require_once $path['common'] . 'login.php';
                $this->action = new Login();
                $this->view = $view->getLogin();
                // include_once 'loginView';
                break;
            case 'save':
                require_once "path['common']save.php";
                $this->action = new Save();
                // include_once 'saveView';
                break;
            case 'create':
                break;
            case 'delete':
                break;
            case 'logout':
                require_once $path['common'] . 'logout.php';
                $this->action = new Logout();
                // include_once 'logoutView';
                break;
            default:
                //$view->getDefault();
                break;
        }
    }


    function execute()
    {
    }

    /**
     * Gets the action from the route.
     *
     * @param unknown $action
     */
    public function getAction()
    {
        global $path;

        if ( ! array_key_exists('path', $this->request))
        {
            // Default controller and view.
            $this->action = 'default';
            return;
        }
        $controller = urldecode(urldecode(rawurldecode($this->request['path'])));
        $controller = html_entity_decode($controller);
        $parts = explode('/', $controller);
        if (file_exists($path['controllers'].$parts[0])){
                $this->action = $parts[0];
                unset($parts[0]);
                $this->arguments = $parts;
        }else{
            $this->action = 'default';
        }
    }

    public function exitWithError($params)
    {
    }
}
