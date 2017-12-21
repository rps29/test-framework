<?php
namespace Core\Page;

class ViewObject
{

    public $_template = '';

    protected $_request;


    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

}
