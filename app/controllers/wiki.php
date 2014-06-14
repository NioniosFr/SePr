<?php
if (! defined('CW'))
    exit('invalid access');

class WikiController implements Controller
{

    var $errored;

    function __construct()
    {
        global $error, $session;

        $this->init(func_get_args());

        if (! $session->loggedIn) {
            $error->setError('You cannot access that content.', 'Permission Denied');
            $this->errored = true;
        } else {
            $this->errored = false;
        }
    }

    public function init($args)
    {
        $this->model = $args[0];
        $this->view = $args[1];
    }

    function index()
    {
        global $session, $error;
        if ($this->errored || ! $session->user || ! $session->userPermissions) {
            if (! $this->errored) {
                $error->setError('Undefined user', 'Permission Denied', 120);
            }
            return;
        }
        if (! $session->userPermissions['read']) {
            $error->setError('You do not have read permissions.', 'Permission Denied');
            return;
        }

        $pages = $this->model->getPagesOverview();
        for ($i = 0, $max = count($pages); $i < $max; $i ++) {
            $pages[$i]['action'] = array();
            $id = $pages[$i]['id'];
            $pages[$i]['action']['view'] = 'view/?id=' . $id;
            $pages[$i]['action']['edit'] = 'edit/?id=' . $id;
            $pages[$i]['action']['delete'] = 'delete/?id=' . $id;
        }
        $this->view->params['pages'] = $pages;
        $this->view->setView('index');
    }

    function addPage()
    {
        if ($this->errored) {
            return;
        }

        $this->view->setView('addPage');
    }

    function view()
    {}

    function delete()
    {}

    function edit()
    {
        $this->view->setView('editPage');
    }
}