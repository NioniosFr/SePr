<?php
if (! defined('CW'))
    exit('invalid access');

/**
 * The controller interface.
 *
 * Every controller should implement this interface.
 *
 * @author nionios
 *
 */
interface Controller
{

    /**
     * Intented to initialize the model and view classes for internal usage.
     *
     * @param array $args
     */
    public function init($args);

    /**
     * The default action of every controller.
     */
    public function index();
}
