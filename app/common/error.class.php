<?php
if (! defined('CW'))
    exit('invalid access');

/**
 * Default error class.
 *
 * Will be checked for errors on every step, if not error found
 */
class Error{
        var $errors;
        var $errorMsg;
    	var $errorNr;
    	var $errorParrent;
        var $hasErrors;

    function __construct()
    {
        $this->errors = array();
        $this->errorMsg = '';
        $this->errorNr = '';
        $this->errorParent = '';
        $this->hasErrors = false;
    }

    function __get($param)
    {
        return ($param == 'hasErrors') ? count($errors) : $this->$param;
    }

    function __set($array, $isArray=false)
    {
        if (!$isArray)
            return ;

        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }
}