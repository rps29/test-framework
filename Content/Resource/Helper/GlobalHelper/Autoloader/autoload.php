<?php
require_once "DependencyInjector.php";

spl_autoload_register('autoload');


function autoload(string $class)
{
    $adjust = str_replace("\\", "/", $class);
    $file = "$adjust.php";

    require_once $file;
}


$injector = new \Content\Resource\Helper\GlobalHelper\Autoloader\DependencyInjector();

/**
 * Dependency Injection
 *
 * Saves once instantiated objects in order not to instantiate them twice in runtime.
 * Defining global $injector for DependencyInjector->getClass(); working properly.
 */
function inject(string $class, bool $create = false)
{
    try
    {
        global $injector;
        return $injector->inject($class, $create);
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }
}

/**
 * Injects a new instance of given class.
 * Not affecting DependencyInjector->_loaded property.
 */
function create(string $class)
{
    try
    {
        global $injector;
        return $injector->inject($class, true);
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }
}
