<?php
if (! defined('CW'))
    exit('invalid access');

class UserController implements Controller
{

    function __construct()
    {
        $this->init(func_get_args());
    }

    public function init($args)
    {
        $this->model = $args[0];
        $this->view = $args[1];
    }

    public function index()
    {
        $this->view->setView('index');
    }

    /**
     * Checks for the right arguments being passed.
     *
     * Calls the model to check wether the user exists.
     *
     * @return Logges the user if exists, otherwise responds error.
     */
    public function login($args)
    {
        global $error;
        var_dump($args);
        if (empty($args[0]) || empty($args[1])) {
            $error->setError('Missing Arguments: You need to specify a username and a password.');
            $this->view->setView('login');
        }
    }

    public function logout()
    {
        global $view;
        $this->view->setView('logout');
    }
}