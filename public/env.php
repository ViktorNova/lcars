<?php
/**
 * @author xerox
 */

/**
 * define environment
 */
defined('PHP_PEAR_PATH')
    || define(
        'PHP_PEAR_PATH',
        realpath(__DIR__
            . '/usr/share/php5/PEAR/'));

defined('LIBRARY_PATH')
    || define('LIBRARY_PATH', realpath(__DIR__
        . '/../library/'));

defined('APPLICATION_PATH')
    || define(
        'APPLICATION_PATH',
        realpath(__DIR__
            . '/../application/'));

defined('APPLICATION_ENV')
    || define(
        'APPLICATION_ENV',
        (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

/*
 * ini settings
 */
if (APPLICATION_ENV
    == 'development')
{
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);

}

/*
 * set autoload
 */
spl_autoload_register(
    function (
        $className)
    {
        $paths = array(
            "application" => '/../application/',
            "library" => '/../library/'
        );

        foreach ($paths as $path)
        {
            $classFile = __DIR__
                . $path
                . strtr($className, '\\', DIRECTORY_SEPARATOR)
                . '.php';

            if (is_readable($classFile))
            {
                $class = $classFile;
                include_once $class;
            }
        }
    });
