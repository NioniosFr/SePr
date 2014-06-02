<?php
if (! defined('CW'))
    exit('invalid access');

/**
 * Default error class.
 *
 * Will be checked for errors on every step, if not error found
 */
class Error
{

    var $error;

    var $hasErrors;

    function __construct()
    {
        $this->error = array();
        $this->hasErrors = false;
    }

    function __get($param)
    {
        return $this->$param;
    }

    public function printErrorMsg()
    {
        if ($this->hasErrors) {
            echo '<div class="alert alert-danger">';
            echo '<ol>';
            foreach ($this->error as $err) {
                echo '<li><b>'.$err['type']. ': '. $err['msg'] . '</b></li>';
            }
            echo '</ol>';
            echo '</div>';
        } else
            echo '';
    }

    public function setError($message, $errorType = '', $errorNr = -1)
    {
        array_push($this->error, array(
            'type' => $errorType,
            'msg' => $message,
            'nr' => $errorNr
        ));
        $this->hasErrors = count($this->error);
    }
}