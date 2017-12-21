<?php
/**
 * Core\Page\Html\Head
 * Rendering <head> to valid HTML.
 *
 * Template: Core/Page/Html/head.phtml
 */

namespace Core\Page\Html;

use Core\Page\ViewObject;

class Head extends ViewObject
{

    // TODO: Refactor: $this->setAttribute() not working properly (nothing is being set)
    public $model = [
        'page_title' => DEFAULT_PAGE_TITLE,
        'page_icon' => DEFAULT_PAGE_ICON,
        'script' => [],
        'link' => [],
        'meta' => []
    ];

    public $template = 'Core/Page/Html/head.phtml';


    /**
     * Sets an attribute for head.phtml
     * @param array|string $value
     */
    public function setAttribute(string $modelKey, string $value)
    {
        switch ($modelKey)
        {
            case 'script':
            case 'meta':
            case 'link':
                $this->model[$modelKey][] = $value;
                break;
            default:
                $this->model[$modelKey] = $value;
        }
        return $this;
    }


    /**
     * Sets multiple attributes for head.phtml
     */
    public function setAttributes(array $modelKeys, array $values)
    {
        foreach ($modelKeys as $index => $key) {
            $this->setAttribute($key, $values[$index]);
        }

        return $this;
    }


    /**
     * SEO
     * Sets <meta name="description"> HTML head tag.
     */
    public function setMetaDescription(string $description)
    {
        $this->model['meta_description'] = $description;
    }


    /**
     * SEO
     * Sets <meta name="keywords"> HTML head tag.
     */
    public function setMetaKeyword(string $keyword)
    {
        $this->model['meta_keywords'] .= $keyword;
    }


    /**
     * @return string Current language
     */
    public function getLang()
    {
        return $this->request->getLanguage();
    }


    /**
     * @return string Specified <meta> tag
     */
    public function getMeta(string $key)
    {
        return $this->model["meta_$key"] ?? '';
    }


    /**
     * @return string Page title (set in current controller)
     */
    public function getPageTitle()
    {
        return $this->model['page_title'];
    }


    /**
     * @return string URL for the page icon
     */
    public function getPageIcon()
    {
        return $this->model['page_icon'];
    }


    public function getAdditionalHtml(string $modelKey, string $raw)
    {
        $html = '';
        foreach ($this->model[$modelKey] as $tag) {
            $html .= $raw . "\n";//"\n\t";//TODO: sprintf($raw, $tag);
        }
        return $html;
    }

    //$html .= "<script type='$tag[0]' src='$tag[1]'></script>\n\t";
    //$html .= "<link rel='$tag[0]' href='$tag[1]' />\n\t";
    //$html .= "<meta name='$tag[0]' content='$tag[1]' lang='{$block->getLang()}'/>\n\t";

}
