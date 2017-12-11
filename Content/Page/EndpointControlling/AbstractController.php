<?php
namespace Content\Page\EndpointControlling;

use Content\Page\Request;
use Content\Page\RenderObject as Renderer;
use Content\Resource\Helper\Db\DbAction;

abstract class AbstractController
{

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var Renderer
     */
    protected $_renderer;

    /**
     * @var DbAction
     */
    protected $_db;


    /**
     * Method called to run by requested endpoint (controller)
     */
    abstract public function execute();


    public function __construct(Request $request, Renderer $renderer, DbAction $dbAction)
    {
        $this->_request = $request;
        $this->_renderer = $renderer;
        $this->_db = $dbAction;
    }


    /**
     * @return \Content\Page\Html\Head
     */
    protected function getHead()
    {
        return $this->_renderer->head;
    }


    /**
     * Set authorization level for current endpoint.
     * Method must be overridden for defining higher authorization.
     * All levels / rules must be defined in its respective model (not existing yet).
     */
    public function setAuthorization()
    {
        return DEFAULT_AUTHORIZATION;
    }


    /**
     * TODO: Add 2nd 'strict' parameter for calling url() function inside before redirecting. If strict isn't given, redirect raw URL.
     * Same logic as url()->urlToHtml();
     *
     * Redirect user on demand to specified URL (controller)
     */
    public function redirect(string $urlRedirect)
    {
        header("Location: $urlRedirect", true);
        die;
    }

}
