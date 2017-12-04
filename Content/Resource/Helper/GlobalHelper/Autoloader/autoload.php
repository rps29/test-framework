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
 * Dependency Injection using singletons
 * Saves once instantiated objects in order not to instantiate them twice in runtime.
 */
function inject(string $class)
{
    try
    {
        global $injector;
        return $injector->inject($class);
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }
}

/**
 * Injects a new instance of given class.
 * Not affecting DependencyInjector->_loaded property.
 * @return object new $class
 */
function create(string $class)
{
    try
    {
        $injector = new \Content\Resource\Helper\GlobalHelper\Autoloader\DependencyInjector();
        return $injector->inject($class);
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }
}
