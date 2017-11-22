<?php
namespace Content\Resource\Helper\GlobalHelper\UrlBuilder;

use Content\Page\Request;

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
        if (is_null($resourceUrl))
        {
            return $this;
        }

        $this->_resource = $resourceUrl;
        $this->_arguments = $arguments;

        return $this->getUrl();
    }


    public function urlToHtml(string $resourceUrl, array $arguments = [], string $html = '', bool $raw = false, string $target = '')
    {
        if ($raw)
        {
            $url = $resourceUrl;
        }
        else
        {
            $url = $this->url($resourceUrl, $arguments);
        }

        if (!$html) $html = $url;

        if ($target) $target = "target='$target'";

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
        // remove leading slashes from string
        while (substr($resource, 0, 1) === '/')
        {
            $resource = substr($resource, 1);
        }
        // remove slashes on end of string
        while (substr($resource, -1) === '/')
        {
            $resource = substr($resource, 0, strlen($resource) - 1);
        }

        // TODO: extract this logic to a private "adjustResource()" function
        $ar = explode('/', $resource);
        foreach ($ar as &$item)
        {
            $item = trim(strtolower(implode(preg_split('/(?=[A-Z])/', $item), '-')), " \t\n\r\0\x0B-");
        }

        return implode($ar, '/');
    }


    /**
     * // TODO: Extract special arguments e.g. _current, _lang to i.e. $this->parseArgumentsForQuery();
     *
     * @return string URL query snippet for $_GET usage
     */
    private function getQuery()
    {
        $query = '';
        $arguments = $this->_arguments;

        // determine whether to re-use currently requested $_GET arguments
        if (isset($arguments['_current']))
        {
            $arguments = array_merge($this->_request->getCurrentParams(), $arguments);
            unset($arguments['_current']);
        }

        // set language for URL being built
        if (isset($arguments['_lang']))
        {
            $this->_request->_language = $arguments['_lang'];
            unset($arguments['_lang']);
        }

        if (empty($arguments)) return '';

        foreach ($arguments as $key => $value)
        {
            $query .= "$key/$value/";
        }

        return "/query/$query";
    }


    /**
     * @return string URL language snippet
     */
    private function getLanguage()
    {
        return $this->_request->getLanguage('lower') . "/";
    }

}
