<?php
namespace Core\Resource\Helper\GlobalHelper\UrlBuilder;

use Core\Page\Request;

class UrlBuilder
{

    private $_resource = '';

    private $_arguments = [];

    public $_request;


    public function __construct(Request $request)
    {
        $this->_request = $request;
    }


    public function url(string $resourceUrl = null, array $arguments = [])
    {
        if (is_null($resourceUrl)) {
            return $this;
        }
        $this->_resource = $resourceUrl;
        $this->_arguments = $arguments;
        return $this->getUrl();
    }


    public function urlToHtml(string $resourceUrl, array $arguments = [], string $html = '', bool $raw = false, string $target = '')
    {
        if ($raw) {
            $url = $resourceUrl;
        } else {
            $url = $this->url($resourceUrl, $arguments);
        }
        if (!$html) {
            $html = $url;
        }
        if ($target) {
            $target = "target='$target'";
        }
        return "<a $target href='$url'>$html</a>";
    }


    /**
     * @return string built and valid URL
     */
    private function getUrl()
    {
        $controller = $this->getResource();
        $query = $this->getQuery();
        $language = $this->getLanguage();
        return BASE_URL . $language . $controller . $query;
    }


    /**
     * @return string URL controller snippet
     */
    private function getResource()
    {
        $resource = $this->_resource;
        while (substr($resource, 0, 1) === '/') {
            $resource = substr($resource, 1);
        }
        while (substr($resource, -1) === '/') {
            $resource = substr($resource, 0, strlen($resource) - 1);
        }
        return $this->adjustResource($resource);
    }


    /**
     * @return string validated URL.
     * Camel-Case will be converted to lowercase replaced by '-'.
     * Example:
     * 'home/contact/howToContact'  =>  'home/contact/how-to-contact'
     * This URL pattern will be converted back for loading properly controller. That means, that
     * 'how-to-contact' runs HowToContact controller.
     */
    private function adjustResource($resource)
    {
        $ar = explode('/', $resource);
        foreach ($ar as &$item) {
            $item = trim(strtolower(implode(preg_split('/(?=[A-Z])/', $item), '-')), " \t\n\r\0\x0B-");
        }
        return implode($ar, '/');
    }


    /**
     * @return string URL query snippet for $_GET usage
     */
    private function getQuery()
    {
        $this->parseArguments();
        $query = '';
        $arguments = $this->_arguments;
        if (empty($arguments)) {
            return '';
        }
        foreach ($arguments as $key => $value) {
            $query .= "$key/$value/";
        }
        return "/q/$query";
    }


    /**
     * Run associated callback and remove its entry from $this->_arguments for specific keys (defined at $model)
     */
    private function parseArguments()
    {
        $model = [
            '_current' => function(){
                $this->_arguments = array_merge($this->_request->getCurrentParams(), $this->_arguments);
            },
            '_lang' => function(){
                $this->_request->_language = $this->_arguments['_lang'];
            }
        ];
        foreach ($model as $k => $v) {
            $this->parseArgument($k, $v);
        }
    }


    private function parseArgument($key, $callback)
    {
        if (isset($this->_arguments[$key])) {
            $callback();
            unset($this->_arguments[$key]);
        }
    }


    /**
     * @return string URL language snippet
     */
    private function getLanguage()
    {
        return $this->_request->getLanguage() . "/";
    }

}
