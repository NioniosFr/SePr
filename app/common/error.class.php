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

    /**
     * Displays the errors, if any, in HTML format.
     *
     * @return Echoes an html ordered list of errors.
     */
    public function printErrorMsg()
    {
        if ($this->hasErrors) {
            echo '<div class="alert alert-danger">';
            echo '<ol>';
            foreach ($this->error as $err) {
                echo '<li><b>' . htmlspecialchars($err['type']) . ': ' . htmlspecialchars($err['msg']) . '</b></li>';
            }
            echo '</ol>';
            echo '</div>';
        } else
            echo '';
    }

    /**
     * Sets an error to the list of error that occured.
     *
     * @param string $message
     *            The error message.
     * @param string $errorType
     *            (Optional)The error type. Defaults to empty string
     * @param string $errorNr
     *            (Optional) Errors with number > 100 are considered severe. Defaults to -1.
     */
    public function setError($message, $errorType = '', $errorNr = -1)
    {
        array_push($this->error, array(
            'type' => $errorType,
            'msg' => $message,
            'nr' => $errorNr
        ));
        $this->hasErrors = count($this->error);
    }

    /**
     * Reports if errors with errorNr > 100 have occured.
     *
     * @return boolean
     */
    public function severeErrorOccured()
    {
        if ($this->hasErrors) {
            foreach ($this->error as $error) {
                if ($error['nr'] > 100) {
                    return true;
                }
            }
        }
        return false;
    }
}