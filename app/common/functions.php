
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
