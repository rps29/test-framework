<?php
namespace Content\Page\EndpointControlling;

use Content\Page\RenderObject as Renderer;
use Content\Page\Request;
use Content\Page\ViewObject;

class Controller
{

    private $_request;

    private $_renderer;

    private $_viewObject;


    public function __construct(Request $request, Renderer $renderer, ViewObject $viewObject)
    {
        $this->_request = $request;
        $this->_renderer = $renderer;
        $this->_viewObject = $viewObject;
    }


    /**
     * Main function called in Index.php
     * More functionality may be added in future changes
     */
    public function run()
    {
        $this->enforceHttps();
        $controller = $this->loadController();

        if (!$this->authorized($controller)) $controller->redirect(url(REDIRECT_403));

        $this->_renderer->_template = $controller->setTemplate();
        $this->_renderer->_pageTitle = $controller->setPageTitle();

        $controller->execute();

        // use output buffering => php.net ob_start()
        $this->_renderer->render();
        $this->_viewObject->toHtml();
    }


    // TODO: test enforceHttps() working properly!
    private function enforceHttps()
    {
        if (ENFORCE_HTTPS && (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']))
        {
            // TODO: $url must be current controller + current query + current language layer set to HTTPS
            $url = BASE_URL;
            header("Location: $url", true, 301);
        }
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


    private function authorized(AbstractController $controller)
    {
        $auth = $controller->setAuthorization();

        // TODO: compare auth with SessionHelper and return if it equals => whether user is allowed to access endpoint

        return true;
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
