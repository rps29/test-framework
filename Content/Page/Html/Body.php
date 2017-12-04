<?php
namespace Content\Page\Html;

// TODO: Body
class Body
{

    public $_templateHtml;

    public function getHtml()
    {
        $template = file_get_contents('Content/Page/Html/body.phtml');

        $replace = $this->_templateHtml;

        return str_replace('$content', $replace, $template);
    }

    public function setTemplateHtml($html)
    {
        $this->_templateHtml = $html;

        return $this;
    }

    public function addBreadCrumb()
    {
        // ...
        return $this;
    }

}
