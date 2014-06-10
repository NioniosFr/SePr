
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
        if (strlen($value) > 0 && $value[count($value) - 1] != '/')
            $new[$key] = BASE . $value . '/';
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
function sanitizeTypeFromRequest($key, $type = 'STRING', $default = '')
{
    if (! array_key_exists($key, $_REQUEST)) {
        if (empty($defaul)) {
            return null;
        } else {
            return $default;
        }
    }

    $returnable;
    switch ($type) {
        case 'INT':
            if (is_numeric($_REQUEST[$key]))
                $returnable = (1 * $_REQUEST[$key]);
            break;
        case 'DOUBLE':
            if (is_numeric($_REQUEST[$key]))
                $returnable = (1.0 * $_REQUEST[$key]);
            break;
        case 'MAIL':
        case 'DATE':
        case 'STRING':
        default:
            $returnable = sprintf("%s", $_REQUEST[$key]);
            break;
    }

    return ($returnable === null && empty($default)) ? $returnable : $default;
}
