<?php
if (! defined('CW'))
    exit('invalid access');

global $path, $view, $error;

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
        global $path, $error;
        $this->getAction();
        if ($this->action === 'default') {
            return;
        }

        require_once $path['controllers'] . $this->action . '.php';

        $this->action = ucfirst($this->action);
        $this->action = new $this->action();
        if (! empty($this->arguments)) {
            $func = $this->arguments[0];
            unset($this->arguments[0]);
            $this->arguments = array_values($this->arguments);

            try {
                if (method_exists($this->action, $func)) {
                    $this->action->{$func}($this->arguments);
                }
            } catch (Exception $e) {
                $error->setError('Undefined Method.');
            }
        } else {
            $this->action->index();
        }
}

function execute()
{}

    /**
     * Gets the action from the route.
     *
     * @param unknown $action
     */
    public function getAction()
    {
        global $path, $error;
        $this->action = 'default';

        if (! array_key_exists('path', $this->request)) {
            // Default controller and view.
            return;
        }

        $uri = urldecode(urldecode(rawurldecode($this->request['path'])));
        $uri = htmlspecialchars(html_entity_decode($uri));
        $uriParts = explode('/', $uri);

        if (file_exists($path['controllers'] . $uriParts[0] . '.php')) {
            $this->action = $uriParts[0];
            unset($uriParts[0]);
            if (empty($uriParts[1])) {
                return;
            } else {
                // TODO: Sanitize that.
                $this->arguments = array_values($uriParts);
            }
        } else {
            $error->setError('Undefined action: ' . htmlentities($uriParts[0]));
        }
    }
}
