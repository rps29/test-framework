<?php
namespace Content\Page\Html;

// TODO: Head
class Head
{

    public $_html = '';

    public $_replace = [];

    public function getHtml()
    {
        $template = file_get_contents('Content/Page/Html/head.phtml');

        foreach ($this->_replace as $toReplace => $newVal)
        {
            $template = str_replace('$' . $toReplace, $newVal, $template);
        }

        return $template;
    }

    public function setTitle(string $title)
    {
        $this->_replace['title'] = $title;

        return $this;
    }

    public function addJsSource($src, $type = 'text/javascript')
    {
        $this->_replace['script'][] = "<script type='$type' src='$src'></script>";

        return $this;
    }

    // Functionality with linebreaks and tabs could be removed in future changes. Depends on the ongoing development.
    public function prepare()
    {
        $html = '';

        foreach ($this->_replace['script'] as $key => $source)
        {
            if ($key !== 0) $html .= '    '; // nur für quelltext lesbarkeit

            $html .= $source;

            if ($source !== end($this->_replace['script'])) $html .= "\n"; // nur für quelltext lesbarkeit
        }

        $this->_replace['script'] = $html;
    }

}
