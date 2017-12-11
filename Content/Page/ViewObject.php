<?php
namespace Content\Page;

class ViewObject
{

    protected $_request;


    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

}
