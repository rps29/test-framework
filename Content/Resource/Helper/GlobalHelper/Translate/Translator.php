<?php
namespace Content\Resource\Helper\GlobalHelper\Translate;

use Content\Resource\Helper\GlobalHelper\Translate\ImportTranslation as Importer;

class Translator
{

    protected $_importer;

    protected $_availableTranslations = [];


    /**
     * String to be translated
     */
    protected $_fetched = '';


    /**
     * On failure:
     * throw Exception | return original string
     *
     * @var bool $_strict
     */
    protected $_strict;


    public function __construct(Importer $importer)
    {
        $this->_importer = $importer;
    }


    /**
     * Return translation | original string
     */
    public function trans(string $toTranslate, bool $strict = TRANSLATE_STRICT_DEFAULT)
    {
        $this->_fetched = $toTranslate;
        $this->_strict = $strict;
        $this->_availableTranslations = array_column($this->_importer->getTranslations(), 0);

        if (in_array($this->_fetched, $this->_availableTranslations, true))
        {
            return $this->getParsedTranslation();
        }
        else
        {
            return $this->error("Call to method trans() could not find defined translation string. Failed to translate string: {$this->_fetched}");
        }
    }


    /**
     * Translation failure handle
     */
    protected function error(string $error)
    {
        if ($this->_strict)
        {
            throw new \Exception($error);
        }
        else
        {
            return $this->_fetched;
        }
    }


    /**
     * Set $_translation
     */
    protected function getParsedTranslation()
    {
        $fileRow = array_search($this->_fetched, $this->_availableTranslations);

        return $this->_importer->getTranslations()[$fileRow][1];
    }

}
