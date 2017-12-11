<?php
/**
 * Content\Page\Html\Head
 * Rendering <head> to valid HTML.
 *
 * Template: Content/Page/Html/head.phtml
 */

namespace Content\Page\Html;

use Content\Page\Request;
use Content\Page\ViewObject;

class Head extends ViewObject
{

    /**
     * TODO: remove Model->_headModel Property and use $this->_model (this property) straight
     * Todo suggest also prevents class constructor override
     *
     * @var Model
     */
    public $_model;


    public function __construct(Request $request, Model $model)
    {
        $this->_model = $model;
        parent::__construct($request);
    }


    /**
     * Sets an attribute for head.phtml
     *
     * @param array|string $value
     */
    public function setAttribute(string $modelKey, $value)
    {
        $model = [];

        switch ($modelKey)
        {
            case 'script':
            case 'meta':
            case 'link':
                $model[$modelKey][] = $value;
                break;
            default:
                $model[$modelKey] = $value;
        }

        $this->_model->_headModel = array_merge($this->_model->_headModel, $model);

        return $this;
    }


    /**
     * Sets multiple attributes for head.phtml
     */
    public function setAttributes(array $modelKeys, array $values)
    {
        foreach ($modelKeys as $index => $key)
        {
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
        $this->_model->_headModel['meta_description'] = $description;
    }


    /**
     * SEO
     * Sets <meta name="keywords"> HTML head tag.
     */
    public function setMetaKeyword(string $keyword)
    {
        $this->_model->_headModel['meta_keywords'] .= $keyword;
    }


    /**
     * @return string Current language
     */
    public function getLang()
    {
        return $this->_request->getLanguage();
    }


    /**
     * @return string Specified <meta> tag
     */
    public function getMeta(string $key)
    {
        return $this->_model->_headModel["meta_$key"] ?? '';
    }


    /**
     * @return string Page title (set in current controller)
     */
    public function getPageTitle()
    {
        return $this->_model->_headModel['page_title'];
    }


    /**
     * @return string URL for the page icon
     */
    public function getPageIcon()
    {
        return $this->_model->_headModel['page_icon'];
    }


    /**
     * @return array All set <script> tags
     */
    public function getAdditionalScriptTags()
    {
        return $this->_model->_headModel['script'];
    }


    /**
     * @return array All set <link> tags
     */
    public function getAdditionalLinkTags()
    {
        return $this->_model->_headModel['link'];
    }


    /**
     * @return array All set <meta> tags
     */
    public function getAdditionalMetaTags()
    {
        return $this->_model->_headModel['meta'];
    }

}
