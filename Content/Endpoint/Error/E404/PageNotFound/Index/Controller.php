<?php
namespace Content\Endpoint\Error\E404\PageNotFound\Index;

use Content\Page\EndpointControlling\AbstractController;

class Controller extends AbstractController
{

    public function execute()
    {
        echo trans("Hello world!") . "<br><br>";
        echo url()->urlToHtml('test/controller/url', [], 'test HTML display string', false, '_blank');
    }

}
