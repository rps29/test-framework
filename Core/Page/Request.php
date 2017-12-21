<?php
namespace Core\Page;

class Request
{

    /**
     * @var string $_GET['language']
     */
    public $language;

    /**
     * @var string $_GET['layer']
     */
    public $layer;

    /**
     * @var string $_GET['controller']
     */
    public $controller;

    /**
     * @var string $_GET['q']
     */
    public $query;

    /**
     * @var array $_POST
     */
    public $post;


    public function __construct()
    {
        $this->language = $_GET['language'] ?? '';
        $this->layer = $_GET['layer'] ?? '';
        $this->controller = $_GET['controller'] ?? '';
        $this->query = $_GET['q'] ?? '';
        $this->post = $_POST;
    }


    /**
     * @return string current controller
     * Can be used as first parameter (controller) for url()
     */
    public function getCurrentController()
    {
        $controller = $this->controller;
        while (strlen($controller) && substr($controller, 0, 1) === '/') {
            $controller = substr($controller, 1);
        }
        return $controller;
    }


    /**
     * @return array parsed $query
     * Can be used as second parameter (query) for url()
     */
    public function getCurrentParams()
    {
        $aRet = [];
        $request = explode("/", $this->query);
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
     * Doesn't touch or change anything up to $query
     */
    public function mergeParams(array $parameters, array $current = null)
    {
        $base = $current === null ? $this->getCurrentParams() : $current;
        return array_merge($base, $parameters);
    }


    /**
     * @return string parameter value of $query
     */
    public function getParam(string $key)
    {
        $params = $this->getCurrentParams();
        return $params[$key] ?? '';
    }


    /**
     * @param string $format "upper"|"lower"
     * @return string formatted $language
     */
    public function getLanguage(string $format = 'lower')
    {
        $language = $this->language ?: TRANSLATE_DEFAULT_LANG;
        $lower = strtolower($language);
        $upper = strtoupper($language);

        if ($format !== null && isset($$format) && $$format) {
            return $$format;
        }
        return $lower;
    }

}
