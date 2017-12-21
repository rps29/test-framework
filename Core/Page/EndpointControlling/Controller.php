<?php
namespace Core\Page\EndpointControlling;

use Core\Page\{
    RenderObject,
    Request
};

class Controller
{

    private $_request;

    private $_renderer;


    public function __construct(Request $request, RenderObject $renderer)
    {
        $this->_request = $request;
        $this->_renderer = $renderer;
    }


    /**
     * Main function called in Index.php
     * More functionality may be added in future changes
     */
    public function run()
    {
        $this->enforceHttps();
        $controller = $this->loadController();
        if (!$this->authorized($controller)) {
            $controller->redirect(url(REDIRECT_403));
        }
        $controller->execute();
    }


    // TODO: test enforceHttps() working properly!
    private function enforceHttps()
    {
        if (ENFORCE_HTTPS && (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS'])) {
            // TODO: $url must be current controller + current query + current language layer set to HTTPS
            $url = BASE_URL;
            header("Location: $url", true, 301);
        }
    }


    /**
     * Manage URL request and load properly controller
     * @return AbstractController
     */
    private function loadController()
    {
        $namespace = 'Core\Endpoint' . $this->getRequestedControllerNamespace();
        $this->_renderer->_namespace = $namespace; // ToDo: _namespace property might be used for modular system
        $class = "\\$namespace\\Controller";
        $file = substr(str_replace('\\', '/', $class) . '.php', 1);

        if (file_exists($file) && class_exists($class)) {
            $controller = inject($class);
            if (method_exists($controller, 'execute')) {
                return $controller;
            }
        }
        return inject(CONTROLLER_LOAD_404);
    }


    private function authorized(AbstractController $controller)
    {
        $auth = $controller->setAuthorization();
        // TODO: compare auth with SessionHelper and return if it equals => whether user is allowed to access endpoint
        return true;
    }


    /**
     * @return string Endpoint controller namespace to be injected
     */
    private function getRequestedControllerNamespace()
    {
        $controller = $this->_request->getCurrentController();
        if ($controller === '') {
            $controller = 'home';
        }
        $namespace = str_replace(['/', '-'], ['\\', ''], ucwords($controller, '/-'));
        if (substr($namespace, 0, 1) !== '\\') {
            $namespace = "\\$namespace";
        }
        $parts = count(array_filter(explode("\\", $namespace)));
        for ($i = 0; $i < (CONTROLLER_DIRECTORY_FLAT_NUMBER - $parts); $i++) {
            $namespace .= "\\Index";
        }
        return $namespace;
    }

}
