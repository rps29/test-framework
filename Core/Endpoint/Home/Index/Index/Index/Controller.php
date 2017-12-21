<?php
namespace Core\Endpoint\Home\Index\Index\Index;

use Core\{
    Page\EndpointControlling\AbstractController,
    Resource\Helper\GlobalHelper\Logger\ErrorLogger
};

class Controller extends AbstractController
{

    public function execute()
    {
        $head = $this->getHead();
        $head->setAttribute('page_title', 'Home')
            ->setAttribute('script', 'exType');
        $head->setMetaDescription('some descr');
        $this->_renderer->render();
    }

}
