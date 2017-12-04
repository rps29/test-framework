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
    public function inject(string $class)
    {
        if (isset($this->_loaded[$class]))
        {
            return $this->_loaded[$class];
        }

        $reflector = new \ReflectionClass($class);

        if (!$reflector->isInstantiable())
        {
            throw new \Exception("{$class} is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor))
        {
            return $this->getClass($class);
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        $return = $reflector->newInstanceArgs($dependencies);

        return $this->getClass($class, $return);
    }


    /**
     * If class has already been instantiated, return it.
     * Otherwise create new object and return its instance.
     */
    public function getClass(string $class, $instance = null)
    {
        if (substr($class, 0, 1) === "\\")
        {
            $class = substr($class, 1);
        }

        if (!isset($this->_loaded[$class]))
        {
            if ($instance === null)
            {
                $this->_loaded[$class] = new $class;
            }
            else
            {
                $this->_loaded[$class] = $instance;
            }
        }

        return $this->_loaded[$class];
    }


    /**
     * Build up a list of dependencies for given parameters
     */
    public function getDependencies(array $parameters)
    {
        $dependencies = [];

        foreach ($parameters as $param)
        {
            $dependency = $param->getClass();

            if ($dependency === null)
            {
                $dependencies[] = $this->injectNonClass($param);
            }
            else
            {
                if (isset($this->_loaded[$dependency->name]))
                {
                    $dependencies[] = $this->getClass($dependency->name);
                }
                else
                {
                    $dependencies[] = $this->getClass($dependency->name, $this->inject($dependency->name));
                }
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
