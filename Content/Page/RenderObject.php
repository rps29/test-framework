<?php
namespace Content\Page;

use Content\Page\Html\Body;
use Content\Page\Html\Head;

class RenderObject
{

    /**
     * @var string Content\Endpoint\*\*\*\*
     */
    public $_namespace;

    public $_template;


    public function __construct(Head $head, Body $body)
    {
        $this->head = $head;
        $this->body = $body;
    }


    public function render()
    {
        $this->createView($this->head, 'Content/Page/Html/head.phtml');
    }


    public function createView(ViewObject $block, string $template)
    {
        //ob_clean();
        //ob_start();
        require $template;
        //$html = ob_get_clean();
        //return $html;
    }

    /**
     * TODO: ?
     * @return string template being rendered as body main content
     */
    private function getTemplate()
    {
        if (file_exists($this->_template))
            return $this->_template;

        return DEFAULT_TEMPLATE;
    }

}
