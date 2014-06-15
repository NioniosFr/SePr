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
            $this->view->activePage = 'wiki';
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
            $error->setError('You do not have read permissions.', 'Access Restricted');
            return;
        }

        $pages = $this->model->getPagesOverview();
        for ($i = 0, $max = count($pages); $i < $max; $i ++) {
            $this->setActions($pages[$i]);
        }
        $this->view->params['pages'] = $pages;
        $this->view->setView('index');
    }

    function add()
    {
        global $session, $error;
        if ($this->errored || ! $session->user || ! $session->userPermissions) {
            if (! $this->errored) {
                $error->setError('Undefined user', 'Permission Denied', 120);
            }
            return;
        }
        if (! $session->userPermissions['create']) {
            $error->setError('You do not have create permissions.', 'Access Restricted');
            return;
        }

        $this->view->setView('addPage');

        // Show the form if no arguments are passed or no POST request.
        if (func_num_args() === 0 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        // Retrieve the arguments passed (Title and content).
        $args = func_get_args();

        // Check for empty or missing args.
        if (count($args[0]) != 2 || empty($args[0]['title']) || empty($args[0]['content'])) {
            $error->setError('You need to specify both title and content.', 'Missing arguments');
        } else {
            $title = htmlspecialchars($args[0]['title']);
            $content = htmlspecialchars($args[0]['content']);
            // Try to add the new page.
            if ($this->model->addPage($session->user, array(
                'title' => $title,
                'content' => $content
            ))) {
                $session->success = 'Page was created succesfully.';
            } else {
                $error->setError('Page was not be created.', 'Error');
            }
        }
    }

    function view()
    {
        global $session, $error;
        if ($this->errored || ! $session->user || ! $session->userPermissions) {
            if (! $this->errored) {
                $error->setError('Undefined user', 'Permission Denied', 120);
            }
            return;
        }
        if (! $session->userPermissions['read']) {
            $error->setError('You do not have read permissions.', 'Access Restricted');
            return;
        }

        $this->view->setView('viewPage');
        // Show the form if no arguments are passed or no POST request.
        if (func_num_args() === 0 || $_SERVER['REQUEST_METHOD'] !== 'GET') {
            $this->view->setView('index', 'default');
            return;
        }

        $args = func_get_args();

        if (count($args[0]) != 1 || empty($args[0]['id']) || ! is_numeric($args[0]['id'])) {
            $error->setError('You need to specify both title and content.', 'Missing arguments');
            $this->view->setView('index', 'wiki');
        } else {
            $id = sanitizeTypeFromRequest($args[0]['id'], 'INT');
            $page = $this->model->getPageById($id);
        }
        if ($page) {
            $this->setActions($page);
            $this->view->params['page'] = $page;
        } else {
            $error->setError('The page you requested does not exist.', 'Unkown page');
            $this->view->setView('index', 'wiki');
        }
    }

    function delete()
    {
        global $session, $error;
        if ($this->errored || ! $session->user || ! $session->userPermissions) {
            if (! $this->errored) {
                $error->setError('Undefined user', 'Permission Denied', 120);
            }
            return;
        }
        if (! $session->userPermissions['delete']) {
            $error->setError('You do not have delete permissions.', 'Action Denied');
            return;
        }
        $args = func_get_args();

        if (empty($args[0]['id']) || ! is_numeric($args[0]['id'])) {
            $error->setError('You need to specify a page first.', 'Missing arguments');
            $this->view->setView('index', 'wiki');
        } else {
            $id = sanitizeTypeFromRequest($args[0]['id'], 'INT');
            $page = $this->model->getPageById($id);
            if ($page) {
                if ($this->model->deletePage($id)) {
                    $session->success = sprintf('The page with id: %d was <strong>deleted</strong> succesfully.', $id);
                } else {
                    $error->setError('The page could not be deleted.', 'Delete Failed');
                }
            } else {
                $error->setError('There was no page found with the given ID', 'Malformed request');
            }
        }
        $this->view->setView('index', 'wiki');
    }

    function edit()
    {
        global $session, $error;
        if ($this->errored || ! $session->user || ! $session->userPermissions) {
            if (! $this->errored) {
                $error->setError('Undefined user', 'Permission Denied', 120);
            }
            return;
        }
        if (! $session->userPermissions['update']) {
            $error->setError('You do not have update permissions.', 'Access Restricted');
            return;
        }

        $this->view->setView('editPage');
        // Show the form if no arguments are passed or no POST request.
        if (func_num_args() === 0) {
            $this->view->setView('index', 'default');
            return;
        }

        $args = func_get_args();

        if (empty($args[0]['id']) || ! is_numeric($args[0]['id'])) {
            $error->setError('You need to specify a page first.', 'Missing arguments');
            $this->view->setView('index', 'wiki');
        } else {
            $id = sanitizeTypeFromRequest($args[0]['id'], 'INT');
            $page = $this->model->getPageById($id);
        }

        if ($page) {
            $this->setActions($page);
            $this->view->params['page'] = $page;
        } else {
            $error->setError('The page you requested does not exist.', 'Unkown page');
            $this->view->setView('index', 'wiki');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view->setView('editPage');
            return;
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (empty($args[0]['title']) || empty($args[0]['content']) || empty($args[0]['hi'])) {
                    $error->setError('You need to specify both title and content.', 'Missing arguments');
                } elseif ($id != $args[0]['hi']) {
                    $error->setError('Undefined request.', 'Malformed request', 130);
                } else {

                    if ($this->model->editPage($id, $session->user, array(
                        'title' => $args[0]['title'],
                        'content' => $args[0]['content']
                    ))) {
                        $session->success = 'Page updated succesfully';
                        $page = $this->model->getPageById($id);
                        $this->setActions($page);
                        $this->view->params['page'] = $page;
                        $this->view->setView('viewPage');
                    } else {
                        $error->setError('Page was not updated.', 'Error');
                        $this->view->setView('viewPage');
                    }
                }
            }
        }
    }

    /**
     * Returns the actions this controlles supports, as an array of links.
     */
    private function setActions(&$page)
    {
        $page['action'] = array();
        $id = $page['id'];

        $page['action']['view'] = 'wiki/view/?' . http_build_query(array(
            'id' => $id
        ));
        $page['action']['edit'] = 'wiki/edit/?' . http_build_query(array(
            'id' => $id
        ));
        $page['action']['delete'] = 'wiki/delete/?' . http_build_query(array(
            'id' => $id
        ));
    }
}
