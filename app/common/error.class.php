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

    static $error = array();

    static $hasErrors = false;

    /**
     * Allow access of variables like they where referenced from within the object.
     * ie. self::$error can be access also like:
     * <code>
     * $error = new Error();
     * $error->error;
     * </code>
     *
     * @param string $param
     *            The name if the parameter
     * @return mixed NULL parameter if exists, null otherwise.
     */
    function __get($param)
    {
        return isset(self::${$param}) ? self::${$param} : null;
    }

    /**
     * Displays the errors, if any, in HTML format.
     *
     * @return Echoes an html ordered list of errors.
     */
    static public function printErrorMsg()
    {
        if (self::$hasErrors) {
            echo '<div class="alert alert-danger">';
            echo '<ol>';
            foreach (self::$error as $err) {
                echo '<li><b>' . htmlspecialchars($err['type']) . ': <code>' . htmlspecialchars($err['msg']) . '</code></b></li>';
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
    static public function setError($message, $errorType = '', $errorNr = -1)
    {
        array_push(self::$error, array(
            'type' => $errorType,
            'msg' => $message,
            'nr' => $errorNr
        ));
        self::$hasErrors = count(self::$error);
    }

    /**
     * Reports if errors with errorNr > 100 have occured.
     *
     * @return boolean
     */
    static public function severeErrorOccured()
    {
        if (self::$hasErrors) {
            foreach (self::$error as $error) {
                if ($error['nr'] > 100) {
                    return true;
                }
            }
        }
        return false;
    }
}

//global $error = new Error();

/**
 * Gets the error object.
 *
 * @return Error
 */
function get_error_object()
{
    if (isset($error)) {
        var_dump($error .'aaaaaaaa');
        return $error;
    } else {
        $error = new Error();
        var_dump($error);
        return $error;
    }
}
