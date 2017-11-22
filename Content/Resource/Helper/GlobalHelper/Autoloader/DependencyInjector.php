<?php
namespace Content\Resource\Helper\GlobalHelper\Autoloader;

class DependencyInjector
{

    /**
     * Property $_loaded used to store instantiated class objects.
     */
    public $_loaded = [];


    /**
     * Build an instance of the given class
     */
    public function inject(string $class, bool $create = false)
    {
        $reflector = new \ReflectionClass($class);

        if (!$reflector->isInstantiable())
        {
            throw new \Exception("{$class} is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor))
        {
            return $this->getClass($class, $create);
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters, $create);

        return $reflector->newInstanceArgs($dependencies);
    }


    /**
     * If class has already been instantiated, return it.
     * Otherwise create new object and return it.
     */
    public function getClass(string $class, $create)
    {
        if ($create)
        {
            return new $class;
        }

        if (!isset($this->_loaded[$class]))
        {
            $this->_loaded[$class] = inject($class);
        }

        return $this->_loaded[$class];
    }


    /**
     * Build up a list of dependencies for given parameters
     */
    public function getDependencies(array $parameters, $create)
    {
        $dependencies = [];

        foreach ($parameters as $param)
        {
            $dependency = $param->getClass();

            if (is_null($dependency))
            {
                $dependencies[] = $this->injectNonClass($param);
            }
            else
            {
                $dependencies[] = $this->getClass($dependency->name, $create);
            }
        }

        return $dependencies;
    }


    /**
     * Determine what to do with a non-class value
     */
    public function injectNonClass(\ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable())
        {
            return $parameter->getDefaultValue();
        }

        throw new \Exception("(\Content\Resource\Helper\GlobalHelper\Autoloader\DependencyInjector)->injectNonClass(): $parameter");
    }

}
