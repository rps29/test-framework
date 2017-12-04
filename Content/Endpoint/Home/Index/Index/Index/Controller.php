<?php
namespace Content\Endpoint\Home\Index\Index\Index;

use Content\Page\EndpointControlling\AbstractController;

class Controller extends AbstractController
{

    public function execute()
    {
    }

    public function setPageTitle()
    {
        return "Framework Home";
    }

    public function setTemplate()
    {
        return "self::default.phtml";
    }

}
