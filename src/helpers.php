<?php

use Phalcon\Debug\Dump;

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
                return true;
            case 'false':
                return false;
            case 'empty':
                return '';
            case 'null':
                return null;
        }

        return $value;
    }
}

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     *
     * @return string
     */
    function config_path($path = '')
    {
        return DOCROOT.'config'.($path ? "/{$path}" : '');
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dd()
    {
        call_user_func_array('dump', func_get_args());
        die(1);
    }
}

if (!function_exists('dump')) {
    /**
     * Dump the passed variables without end the script.
     *
     * @param  mixed
     * @return void
     */
    function dump()
    {
        array_map(function ($x) {
            $string = (new Dump(null, true))->variable($x);
            echo (PHP_SAPI == 'cli' ? strip_tags($string) . PHP_EOL : $string);
        }, func_get_args());
    }
}
