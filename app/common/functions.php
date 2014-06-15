
<?php
if (! defined('CW'))
    exit('invalid access');

/**
 * Contains multipurpose functions available globally in the app.
 */

/**
 * Adds a slash to the end of a path,
 * allows for easier use when declaring paths.
 *
 * @param array $paths
 *            key=>value, where value is the path.
 * @return array
 */
function fix_config_paths(Array $paths)
{
    $new = array();
    foreach ($paths as $key => $value) {
        if (strlen($value) > 0 && $value[count($value) - 1] != DS)
            $new[$key] = BASE . $value . DS;
        else
            $new[$key] = BASE . $value;
    }
    // Hardcoded fix for base path.
    if (array_key_exists('base', $new))
        $new['base'] = BASE;
    return $new;
}

/**
 * Sanitizes the return type of the request.
 * Returns the correct type for a given request id.
 * If the given variable is not the correct type it returns null, or a default
 * value, if any.
 *
 * @param string $key
 * @param string $type
 * @param string $default
 *            (Optional) a default value to return.
 * @return NULL string NUM DOUBLE
 */
function sanitizeTypeFromRequest($key, $type = 'STRING')
{
    $returnable;
    switch ($type) {
        case 'INT':
            if (is_numeric($key))
                $returnable = (1 * $key);
            break;
        case 'DOUBLE':
            if (is_numeric($key))
                $returnable = (1.0 * $key);
            break;
        case 'MAIL':
        case 'DATE':
        case 'STRING':
        default:
            $returnable = sprintf("%s", $key);
            break;
    }

    return $returnable;
}

/**
 * Escapes a string for safe use in an sql command.
 * Converts html entities back to characters,
 * escapes slashes and semicolons.
 *
 * @param string $string
 * @return string a hopefully escaped string.
 */
function db_escape_string($string)
{
    $string = htmlspecialchars_decode($string);
    $string = preg_replace("/'/", "\'", $string);
    $string = preg_replace("/;/", "\;", $string);
    return $string;
}

/**
 * Used to escape quotes for use in SQL.
 *
 * Convenience function to single-quote a preformated string,
 * before passing it from vsprintf.
 * If a mysqli link is given it will also escape the string
 * with mysqli_real_escape_string
 *
 * @param string $string
 *            The string format
 * @param array $data
 *            The data to pass through vsprintf
 * @param MySQLi $con
 *            The mysqli link
 * @return string
 */
function dvsprintf($string, $data, $con = null)
{
    if ($con != null) {
        //for ($i = 0, $m = count($data); $i < $m; $i ++) {
             foreach ($data as &$param){
            if (is_string($param)) {
                $param = mysqli_real_escape_string($con, $param);
            }
        }unset($param);
    }

    // Quote the strings.
    $quoted = preg_replace('/\%s/', "'%s'", $string);
    return vsprintf($quoted, $data);
}
