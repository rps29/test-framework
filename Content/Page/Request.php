<?php
namespace Content\Page;

class Request
{

    /**
     * @var string $_GET['language']
     */
    public $_language;

    /**
     * @var string $_GET['layer']
     */
    public $_layer;

    /**
     * @var string $_GET['controller']
     */
    public $_controller;

    /**
     * @var string $_GET['query']
     */
    public $_query;

    /**
     * // TODO: Later on: Add getter: getPost(); for special logic parsing e.g. parameters
     *
     * @var array $_POST
     */
    public $_post;


    public function __construct()
    {
        $this->_language = $this->get('language');
        $this->_layer = $this->get('layer');
        $this->_controller = $this->get('controller');
        $this->_query = $this->get('query');
        $this->_post = $_POST;
    }


    /**
     * @return string current controller
     * Can be used as first parameter (controller) for url()
     */
    public function getCurrentController()
    {
        $controller = $this->_controller;

        if (strlen($controller) && (substr($controller, 0, 1) === '/')) {
            return substr($controller, 1);
        }

        return $controller;
    }


    /**
     * @return array parsed $_query
     * Can be used as second parameter (query) for url()
     */
    public function getCurrentParams()
    {
        $aRet = [];
        $request = explode("/", $this->_query);

        if (!$request[0]) {
            unset($request[0]);
            $request = array_values($request);
        }

        for ($i = 0; $i < count($request), isset($request[$i]), isset($request[$i + 1]); $i++) {
            $aRet[$request[$i]] = $request[++$i];
        }

        return $aRet;
    }


    /**
     * @return array that merges given parameters with current query or another parameter array
     * Can be used as second parameter (query) for url()
     */
    public function mergeParams(array $parameters, array $current = null)
    {
        $base = $current === null ? $this->getCurrentParams() : $current;

        return array_merge($base, $parameters);
    }


    /**
     * @return string parameter value of $_query
     */
    public function getParam(string $key)
    {
        $params = $this->getCurrentParams();

        return isset($params[$key]) ? $params[$key] : '';
    }


    /**
     * @param string $format "upper"|"lower"
     * @return string formatted $_language
     */
    public function getLanguage(string $format = 'lower')
    {
        $language = $this->_language ?: TRANSLATE_DEFAULT_LANG;
        $lower = strtolower($language);
        $upper = strtoupper($language);

        if ($format !== null && isset($$format) && $$format)
        {
            return $$format;
        }

        return $lower;
    }


    private function get(string $key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : '';
    }

}
