<?php

use Illuminate\Container\Container;

if (! function_exists('environment_file_path')) {
    /**
     * Get application environment file path.
     *
     * For both Laravel and Lumen framework.
     *
     * @param string  $helper
     * @param string  $envFile
     *
     * @return string
     */
    function environment_file_path($helper = 'environmentFilePath', $envFile = '.env'): string
    {
        $app = Container::getInstance();

        if (method_exists($app, $helper)) {
            return $app->{$helper}();
        }

        // Lumen
        return $app->basePath($envFile);
    }
}

if (! function_exists('alphanumeric')) {
    /**
     * Strip all symbols from a string.
     *
     * @see https://stackoverflow.com/a/16791863/2732184 Source
     *
     * @param string  $str
     *
     * @return string
     */
    function alphanumeric($str): string
    {
        return preg_replace('/[^\p{L}\p{N}\s]/u', '', $str);
    }
}

if (!function_exists('array_get')) {
    /**
     * Get array value by key or default.
     *
     * @param array $haystack The array
     * @param mixed $needle   The searched value
     * @param mixed $default
     *
     * @return mixed
     */
    function array_get(array $haystack, $needle, $default = null)
    {
        return isset($haystack[$needle]) ? $haystack[$needle] : $default;
    }
}

if (!function_exists('is_associative')) {
    /**
     * Is this an associative array?
     *
     * @link https://stackoverflow.com/a/173479/2732184 Source
     *
     * @param array $arr
     *
     * @return bool
     */
    function is_associative(array $arr)
    {
        if ([] === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

if (!function_exists('missing_keys')) {
    /**
     * Get missing array keys.
     *
     * @param array $required
     * @param array $given
     *
     * @return array|null Missing keys
     */
    function missing_keys(array $required, array $given)
    {
        if (is_associative($given)) {
            $given = array_keys($given);
        }

        return array_diff($required, $given);
    }
}
