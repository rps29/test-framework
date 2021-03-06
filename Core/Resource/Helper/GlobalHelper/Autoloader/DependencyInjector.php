<?php
namespace Core\Resource\Helper\GlobalHelper\Autoloader;

class DependencyInjector
{

    /**
     * Property $loaded used to store singleton instances.
     */
    public $loaded = [];


    /**
     * Build an instance of the given class
     */
    public function inject(string $class)
    {
        if (isset($this->loaded[$class])) {
            return $this->loaded[$class];
        }
        $reflector = new \ReflectionClass($class);
        if (!$reflector->isInstantiable()) {
            throw new \Exception("{$class} is not instantiable.");
        }
        $return = $this->injectConstructorArgs($reflector, $class);
        return $this->getClass($class, $return);
    }


    /**
     * Instantiate new constructor params
     * @param \ReflectionClass $reflector
     */
    private function injectConstructorArgs($reflector, $class)
    {
        $constructor = $reflector->getConstructor();
        if ($constructor === null) {
            return $this->getClass($class);
        }
        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);
        return $reflector->newInstanceArgs($dependencies);
    }


    /**
     * If class has already been instantiated, return it.
     * Otherwise create new object and return its instance.
     */
    private function getClass(string $class, $instance = null)
    {
        while (strlen($class) && substr($class, 0, 1) === "\\") {
            $class = substr($class, 1);
        }
        if (!isset($this->loaded[$class])) {
            $this->loaded[$class] = $instance === null ? new $class : $instance;
        }
        return $this->loaded[$class];
    }


    /**
     * Build up a list of dependencies for given parameters (of constructor)
     */
    private function getDependencies(array $parameters)
    {
        $dependencies = [];
        /**
         * @var $param \ReflectionParameter
         */
        foreach ($parameters as $param) {
            $dependency = $param->getClass();
            if ($dependency === null) {
                $dependencies[] = $this->injectNonClass($param);
            } else {
                $instance = null;
                if (!isset($this->loaded[$dependency->name])) {
                    $instance = $this->inject($dependency->name);
                }
                $dependencies[] = $this->getClass($dependency->name, $instance);
            }
        }
        return $dependencies;
    }


    /**
     * Determine what to do with a non-class value
     */
    private function injectNonClass(\ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        throw new \Exception("(\Core\Resource\Helper\GlobalHelper\Autoloader\DependencyInjector)->injectNonClass(): $parameter");
    }

}
