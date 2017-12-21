<?php
namespace Core\Page;

use Core\Page\Html\{
    Body,
    Head
};

class RenderObject
{

    /**
     * @var string Core\Endpoint\*\*\*\*
     */
    public $_namespace;


    public function __construct(Head $head, Body $body)
    {
        $this->head = $head;
        $this->body = $body;
    }

    // TODO: Don't call render() from Controller - Add a renderBefore() and renderAfter() method to AbstractController
    // in order not to force controllers to display HTML.
    // This allows to use Controller for handling some Database other logical stuff and then redirect to another controller
    // that will render HTML output.
    public function render()
    {
        include "Html/page.phtml";
    }


    /**
     * @return string File: $template as rendered HTML
     */
    private function createView(ViewObject $block, string $template = null)
    {
        if ($template === null) {
            if ($block->_template === '') {
                return 'Failed to create view: "' . get_class($block) . '" - No template given.<br/>';
            } else {
                $template = $block->_template;
            }
        }
        if (!file_exists($template)) {
            return 'Failed to create view: "' . $template . '" - Template does not exist.<br/>';
        }

        ob_start();
        include $template;
        return ob_get_clean();
    }

}
