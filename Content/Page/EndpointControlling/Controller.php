<?php
namespace Content\Page\EndpointControlling;

use Content\Page\RenderObject as Renderer;
use Content\Page\Request;

class Controller
{

    private $_request;

    private $_renderer;


    public function __construct(Request $request, Renderer $renderer)
    {
        $this->_request = $request;
        $this->_renderer = $renderer;
    }


    /**
     * Main function called in Index.php
     * More functionality can be added in future changes
     */
    public function run()
    {
        $this->loadController()->execute();
    }


    /**
     * Manage URL request and load properly controller
     */
    private function loadController()
    {
        $namespace = 'Content\Endpoint' . $this->getRequestedController();

        $this->_renderer->_namespace = $namespace;

        $class = "\\$namespace\\Controller";

        $file = substr(str_replace('\\', '/', $class) . '.php', 1);

        if (file_exists($file) && class_exists($class))
        {
            $controller = inject($class);

            if (method_exists($controller, 'execute'))
            {
                return $controller;
            }
        }

        return inject(CONTROLLER_LOAD_404);
    }


    /**
     * @return string Endpoint controller to be injected
     */
    private function getRequestedController()
    {
        $controller = $this->_request->getCurrentController();

        if ($controller === '') $controller = 'home';

        $namespace = str_replace(['/', '-'], ['\\', ''], ucwords($controller, '/-'));

        if (substr($namespace, 0, 1) !== '\\')
        {
            $namespace = "\\$namespace";
        }

        $parts = count(array_filter(explode("\\", $namespace)));

        foreach (range(1, CONTROLLER_DIRECTORY_FLAT_NUMBER - $parts) as $f)
        {
            $namespace .= "\\Index";
        }

        return $namespace;
    }

}
