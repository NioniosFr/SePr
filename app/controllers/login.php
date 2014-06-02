<?php
if (! defined('CW'))
    exit('invalid access');

class Login {

    public function index()
    {
        global $view;
        $view->setView('login', 'index');

    }

    public function logout()
    {
        global $view;
       $view->setView('login', 'logout');
    }


}