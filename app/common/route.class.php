<?php
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
    var $uri;

    /**
     * The query string that followed the URI request.
     *
     * @var string
     */
    var $query;

    /**
     * The actual request.
     * excluding the websites domain.
     *
     * @var string
     */
    var $request;

    /**
     * The requested action.
     *
     * On the URI it comes after the domain and defines the controller to be used.
     *
     * @var string
     */
    var $action;

    /**
     * The controller Object that will be invoked.
     *
     * @var Object
     */
    var $controller;

    /**
     * The method to execute.
     *
     * It derives from the URI. It is defined after the "action" and should point to a method
     * inside the requested controller.
     *
     * @var string
     */
    var $method;

    /**
     * The arguments that came along with the request.
     *
     * Determined after the action and method have been defined.
     *
     * @var array
     */
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
        global $path, $view, $error;

        // Get the requested action (the controllers' name).
        $this->getAction();

        // No special path was requested.
        if ($this->action === 'default') {
            return;
        }

        require_once $path['controllers'] . $this->action . '.php';
        require_once $path['models'] . $this->action . '.php';

        // Define the propper name of the controller class.
        $this->controller = ucfirst($this->action) . 'Controller';
        // Initialize the controllers model.
        $model = ucfirst($this->action) . 'Model';
        $model = new $model();
        $view->folder = $this->action;
        // Initialize the controller.
        $this->controller = new $this->controller($model, $view);

        if ($this->method !== NULL) {
            try {
                if (method_exists($this->controller, $this->method)) {
                    $this->controller->{$this->method}($this->arguments);
                }
            } catch (Exception $e) {
                $error->setError('Undefined Method: ' . $this->method);
            }
        } else {
            // Execute the controllers index function.
            $this->controller->index();
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
                // Reset the indexes and set the arguments array.
                $this->arguments = array_values($uriParts);
                // Find out if there is a method requested.
                $this->method = $this->getMethod();
            }
        } else {
            // Path was requested but didn't much any controller.
            $error->setError('Undefined action: ' . htmlentities($uriParts[0]));
        }
    }

    /**
     * Determine the method that was requested from the user.
     * The default method for a controller (action)is "index" and is not defined in the URI path.
     *
     * @return String | NULL : The method name if any. NULL otherwise.
     */
    public function getMethod()
    {
        // Once the action was determined, the rest of the request
        // was stored as arguments.
        if (empty($this->arguments) || empty($this->arguments[0])) {
            return NULL;
        }

        $func = $this->arguments[0];
        unset($this->arguments[0]);
        // Reset the indexes
        $this->arguments = array_values($this->arguments);
        return $func;
    }

    /**
     * Need to extract the variables from the POST array.
     * These should be form input requests etc.
     */
    public function getArguments()
    {}
}
