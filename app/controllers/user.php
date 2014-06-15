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
                $session->cookie['name'] = 'account';
                $session->user = $this->model->getUserName($mail);
                $session->loggedIn = true;
                $session->createOtun($session->user);
                $session->sessionCookieSave();
                $session->success = "You are now logged In.";
                $this->myAccount();
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
        $session->notice = 'You have been logged out.';
        $this->view->setView('index', 'default');
    }

    public function myAccount()
    {
        global $session, $error;
        if (! $session->loggedIn || ! $session->user) {
            $error->setError('You need to login to access this page.', 'Access restriction');
        }

        $this->view->params['edits'] = $this->model->getPagesEdited($session->user);
        $this->view->params['permissions'] = $session->getUserPermissions($session->user);
        $this->view->params['user'] = array();
        $this->view->params['user']['name'] = $session->user;
        $this->view->params['user']['mail'] = $this->model->getUserEmail($session->user);

        $this->view->setView('account');
    }
}