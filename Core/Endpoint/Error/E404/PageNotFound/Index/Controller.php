<?php
namespace Core\Endpoint\Error\E404\PageNotFound\Index;

use Core\Page\EndpointControlling\AbstractController;

class Controller extends AbstractController
{

    public function execute()
    {
        $head = $this->getHead();
        $head->setAttribute('page_title', '404 page not found')
            ->setAttribute('script', 'some script');
        $head->setMetaDescription('some descr');
        $this->renderer->render();
    }

}
