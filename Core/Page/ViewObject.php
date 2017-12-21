<?php
namespace Core\Page;

class ViewObject
{

    public $template = '';

    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}
