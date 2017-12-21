<?php
namespace Core\Page\EndpointControlling;

use Core\Page\{
    Request,
    RenderObject as Renderer
};
use Core\Resource\Helper\Db\DbAction;

abstract class AbstractController
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @var DbAction
     */
    protected $db;


    /**
     * Method called to run by requested endpoint (controller)
     */
    abstract public function execute();


    public function __construct(Request $request, Renderer $renderer, DbAction $dbAction)
    {
        $this->request = $request;
        $this->renderer = $renderer;
        $this->db = $dbAction;
    }


    /**
     * @return \Core\Page\Html\Head
     */
    protected function getHead()
    {
        return $this->renderer->head;
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
