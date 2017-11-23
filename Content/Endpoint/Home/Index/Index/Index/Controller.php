<?php
namespace Content\Endpoint\Home\Index\Index\Index;

use Content\Page\EndpointControlling\AbstractController;

class Controller extends AbstractController
{

    public function execute()
    {
        echo url()->urlToHtml('home', ['firstKey'=>'firstVal']);

        echo "<br><br>";

        // <TEST
        $newUrlBuilder = create('\Content\Resource\Helper\GlobalHelper\UrlBuilder\UrlBuilder');
        $newLang = $this->_request->getLanguage() === 'de' ? 'en' : 'de';
        echo $newUrlBuilder->urlToHtml('', ['_lang' => $newLang]);
        echo "<br><br>";
        //*/ TEST>

        echo url()->urlToHtml('home');
    }

}
