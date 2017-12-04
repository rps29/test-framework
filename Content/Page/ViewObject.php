<?php
namespace Content\Page;

use Content\Page\Html\Body;
use Content\Page\Html\Head;

class ViewObject
{

    public $_head;

    public $_body;

    public $_foot;


    public function __construct(Head $head, Body $body)
    {
        $this->_head = $head;
        $this->_body = $body;
    }

    public function toHtml()
    {
        $head = $this->_head->getHtml();
        $body = $this->_body->getHtml();

        return $head . "\n" . $body;
    }

}
