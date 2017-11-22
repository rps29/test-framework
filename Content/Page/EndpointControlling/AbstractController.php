<?php
namespace Content\Page\EndpointControlling;

use Content\Page\Request;
use Content\Page\RenderObject as Renderer;

/**
 * TODO:
 * These methods are just suggestions yet.
 *
 * setPageTitle() => Title displayed in browser tab
 * setTemplate() => Set the template being used for current view (idk, defaults existing, etc)
 * addBreadcrumbs() => adds Breadcrumb links to the breadcrumb line
 * setAuthorization() => sets required permissions for accessing the controller endpoint
 * ...
 */
abstract class AbstractController
{

    protected $_request;

    protected $_renderer;


    /**
     * Method called to run by requested endpoint (controller)
     */
    abstract public function execute();


    public function __construct(Request $request, Renderer $renderer)
    {
        $this->_request = $request;
        $this->_renderer = $renderer;
    }


    /**
     * TODO: Add 2nd 'strict' parameter for calling url() function inside before redirecting. If strict isn't given, redirect raw URL.
     * Redirect user on demand to specified URL (controller)
     */
    protected function redirect(string $urlRedirect)
    {
        header("Location: $urlRedirect", true);
        die;
    }

}
