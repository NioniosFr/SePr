<?php
/**
 * Contains the declaration of the route class.
 */
if (! defined('CW'))
    exit('invalid access');

/**
 * Determines which request was asked by the user.
 *
 * @author nionios
 *
 */
class Route
{

    /**
     * The URI that was requested.
     *
     * @var stgring
     */
    private $uri;

    /**
     * The query string that followed the URI request.
     *
     * @var string
     */
    private $query;

    /**
     * The actual request.
     * excluding the websites domain.
     *
     * @var string
     */
    private $request;

    /**
     * The requested action.
     *
     * On the URI it comes after the domain and defines the controller to be used.
     *
     * @var string
     */
    private $action;

    /**
     * The controller Object that will be invoked.
     *
     * @var Object
     */
    private $controller;

    /**
     * The method to execute.
     *
     * It derives from the URI. It is defined after the "action" and should point to a method
     * inside the requested controller.
     *
     * @var string
     */
    private $method;

    /**
     * The arguments that came along with the request.
     *
     * Determined after the action and method have been defined.
     *
     * @var array
     */
    private $arguments;

    /**
     * Route constructor.
     * Gets the request from the server and initializes the required properties.
     */
    function __construct()
    {
        $this->uri = urldecode(rawurldecode($_SERVER['REQUEST_URI']));
        $this->query = $_SERVER['QUERY_STRING'];
        $this->request = $_REQUEST;
        $this->action = '';
        $this->arguments = array();
    }

    /**
     * Sanitizes the request to the server.
     */
    private function sanitizeRequest()
    {
        if (empty($this->request))
            return;
    }

    /**
     * Defaults on the default screen.
     * If a user is logged in he will still be logged in after a wrong route.
     */
    public function determineRequest()
    {
        // Get the requested action (the controllers' name).
        $this->getAction();

        // No special path was requested.
        if ($this->action === 'default') {
            return;
        } else {
            $this->setController();
        }
    }

    /**
     * Initializes the controller and executes the requested method.
     *
     * If a controller or method is passed,
     * it will override the ones that where determined by the request URI.
     *
     * @param string $controller
     *            The controllers class name in lowercase.
     * @param string $method
     *            The method name to execute.
     */
    private function setController($controller = '', $method = '')
    {
        global $path, $view;
        $usingModel = false;

        $this->action = empty($controller) ? $this->action : $controller;
        $this->method = empty($method) ? $this->method : $method;

        if (empty($this->action)) {
            // WTF: default one.
            return;
        } else {
            $controller = $path['controllers'] . $this->action . '.php';
            @require_once ($controller);
            $model = $path['models'] . $this->action . '.php';
            // No model requirement.
            if (file_exists($model)) {
                @require_once ($model);
                $usingModel = true;
            }
        }

        if ($usingModel) {
            // Initialize the controllers model.
            $model = ucfirst($this->action) . 'Model';
            $model = new $model();
        } else {
            $model = null;
        }
        // Controller view folder, is the its name in lowercase.
        $view->folder = $this->action;
        // Define the actual/propper class name for the controller.
        $controllerClass = ucfirst($this->action) . 'Controller';
        // Initialize the controller.
        $this->controller = new $controllerClass($model, $view);
    }

    /**
     * Executes the determined controller.
     */
    public function executeController()
    {
        if ($this->method !== null) {
            try {
                if (method_exists($this->controller, $this->method)) {
                    $this->getArguments();
                    $this->controller->{$this->method}($this->arguments);
                } else {
                    Error::setError($this->method, 'Undefined Method');
                }
            } catch (Exception $e) {
                Error::setError('', 'Undefined Error', 150);
            }
        } else
            if (! empty($this->controller)) {
                // Execute the controllers index function.
                $this->controller->index();
            } else {
                // Default actions here.
                return;
            }
    }

    /**
     * Finalize the route after the controller has finished execution.
     *
     * Checks for sever errors, unauthorized attempts, etc
     * and redirects to the error view to the default if any.
     */
    public function finalCheck()
    {
        global $session, $view;
        if (Error::severeErrorOccured()) {
            $view->setView('index', 'default');
            $view->activePage = 'index';
            $session->resetSession();
        }
    }

    /**
     * Gets the action from the route.
     *
     * @param unknown $action
     */
    public function getAction()
    {
        global $path;
        $this->action = 'default';

        // Get the path request (defined from .htaccess).
        if (! array_key_exists('path', $this->request)) {
            // Default controller and view.
            return;
        }

        $uri = urldecode(urldecode(rawurldecode($this->request['path'])));
        $uri = htmlspecialchars(html_entity_decode($uri));
        $uriParts = explode('/', $uri);

        // Check that the controller name is valid.
        if (file_exists($path['controllers'] . $uriParts[0] . '.php')) {
            // Set the action.
            $this->action = $uriParts[0];
            // Remove it from the parts array.
            unset($uriParts[0]);
            // If no more arguments where given, return.
            if (empty($uriParts[1])) {
                return;
            } else {
                // Set the rest of the uri parts to the arguments array.
                // TODO: Sanitize the URI parts.
                // Find out if there is a method requested.
                $this->method = $this->getMethod(array_values($uriParts));
            }
        } else {
            // Path was requested but didn't much any controller.
            Error::setError(htmlentities($uriParts[0]), 'Undefined action', 150);
        }
    }

    /**
     * Determine the method that was requested from the user.
     * The default method for a controller (action)is "index" and is not defined in the URI path.
     *
     * @param array $args
     *            An indexed array that contains the URI query arguments.
     * @return string | NULL : The method name if any. NULL otherwise.
     */
    public function getMethod($args)
    {
        // Once the action was determined, the rest of the request
        // was stored as arguments.
        if (empty($args) || empty($args[0])) {
            return null;
        }

        return $args[0];
    }

    /**
     * Need to extract the variables from the POST array.
     * These should be form input requests etc.
     */
    public function getArguments()
    {
        if (! isset($this->request['path'])) {
            return $this->arguments = null;
        } else {
            $args = $this->request;
            unset($args['path']);
            if (count($args) <= 0) {
                return null;
            } else {
                return $this->arguments = $args;
            }
        }
    }
}

/**
 * Gets the route object.
 *
 * @return Object Route
 */
function get_route()
{
    if (isset($route) && ! empty($route)) {
        return $route;
        var_dump('route was setted');
    } else {
        return new Route();
    }
}
