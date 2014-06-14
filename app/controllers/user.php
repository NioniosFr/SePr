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
        global $error, $session;
        if (empty($args['mail']) || empty($args['pass'])) {
            $error->setError('You need to specify a username and a password.', 'Missing Arguments');
            $this->view->setView('index');
        } else {
            $mail = mysql_escape_string(sprintf("%s", $args['mail']));
            $pass = mysql_escape_string(sprintf("%s", $args['pass']));
            if ($this->model->checkUserCredentials($mail, $pass)) {
                $this->view->setView('loggedIn');
                $session->cookie['name'] = 'account';
                $session->user = $this->model->getUserName($mail);
                $session->loggedIn = true;
                $session->createOtun($session->user);
                $session->sessionCookieSave();
                $_SESSION['success'] = "You are now logged In.";
            } else {
                $error->setError('The given credentials do not much.', 'Wrong Credentials');
                $this->view->setView('index');
            }
        }
    }

    public function logout()
    {
        global $session;
        if ($session->user) {
            $session->logoutUser($session->user);
            $session->resetSession();
        }
        $_SESSION['notice'] = 'You have been logged out.';
        $this->view->setView('index', 'default');
    }
}