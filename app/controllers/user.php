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
        if (empty($args['user']) || empty($args['pass'])) {
            $error->setError('You need to specify a username and a password.', 'Missing Arguments');
            $this->view->setView('login');
        } else {
            $user = mysql_real_escape_string($args['user']);
            $pass = mysql_real_escape_string($args['pass']);
            if ($this->model->checkUserCredentials($user, $pass)) {
                $this->view->setView('index', 'wiki');
            } else {
                $error->setError('The given credentials do not much.', 'Wrong Credentials');
                $this->view->setView('index');
            }
        }
    }

    public function logout()
    {
        global $view;
        $this->view->setView('index', 'default');
    }
}