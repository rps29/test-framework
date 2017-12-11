<?php
namespace Content\Endpoint\Home\Index\Index\Index;

use Content\Page\EndpointControlling\AbstractController;

class Controller extends AbstractController
{

    public function execute()
    {
        $head = $this->getHead();
        $head->setAttribute('page_title', 'Home')
            ->setAttribute('script', ['exType', 'exSource']);
        $head->setMetaDescription('some descr');
    }

}
