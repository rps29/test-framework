<?php
namespace Content\Page;

class RenderObject
{

    /**
     * @var string Content\Endpoint\*\*\*\*
     */
    public $_namespace;

    public $_template;

    public $_pageTitle;

    public $_viewObject;


    public function __construct(ViewObject $viewObject)
    {
        $this->_viewObject = $viewObject;
    }

    public function render()
    {
        $this->_viewObject
            ->_head
            ->setTitle($this->_pageTitle)
            // check if in Content/Endpoint/*/*/*/*/js/* is any directory or *.js file located
            // if so, add it here. Maybe just add scanForJs() called in prepare() to Head.php
            ->addJsSource('some/source/main.js')
            ->addJsSource('some/other/second/source.js')
            ->prepare();
        $this->_viewObject
            ->_body
            ->setTemplateHtml($this->renderTemplate());
    }


    private function renderTemplate()
    {
        $info = $this->getTemplate();
        // todo: run php code and save template as string without outputting anything right here. Output will be handled by ViewObejct


        $html = eval("?>" . file_get_contents($info));

        return $html;
    }


    private function getTemplate()
    {
        $info = $this->_template;

        if (file_exists($info))
        {
            $file = $info;
        }
        elseif ($pos = strpos($info, '::'))
        {
            // an operator is given, calculate relative path
            $operand = substr($info, 0, $pos);
            $ext = substr($info, $pos + 2);

            $file = $this->calculateOperand($operand, $ext);
        }
        else
        {
            $file = DEFAULT_TEMPLATE;
        }

        return $file;
    }


    private function calculateOperand($key, $extension)
    {
        switch ($key)
        {
            case 'self':
                $givenFile = $this->_namespace . '\\' . ENDPOINT_TEMPLATE_DIR . '\\' . $extension;
                break;
            default:
                return DEFAULT_TEMPLATE;
        }

        if (file_exists($givenFile)) return $givenFile;

        return DEFAULT_TEMPLATE;
    }

}
