<?php
namespace Core\Resource\Helper\GlobalHelper\Translate;

use Core\Resource\Helper\GlobalHelper\Translate\ImportTranslation as Importer;

class Translator
{

    protected $importer;

    protected $availableTranslations = [];


    /**
     * String to be translated
     */
    protected $fetched = '';


    /**
     * On failure:
     * throw Exception | return original string
     *
     * @var bool $strict
     */
    protected $strict;


    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }


    /**
     * Return translation | original string
     */
    public function trans(string $toTranslate, bool $strict = TRANSLATE_STRICT_DEFAULT)
    {
        $this->fetched = $toTranslate;
        $this->strict = $strict;
        $this->availableTranslations = array_column($this->importer->getTranslations(), 0);

        if (in_array($this->fetched, $this->availableTranslations, true))
        {
            return $this->getParsedTranslation();
        }
        else
        {
            return $this->error("Call to method trans() could not find defined translation string. Failed to translate string: {$this->fetched}");
        }
    }


    /**
     * Translation failure handle
     */
    protected function error(string $error)
    {
        if ($this->strict)
        {
            throw new \Exception($error);
        }
        else
        {
            return $this->fetched;
        }
    }


    /**
     * Set $translation
     */
    protected function getParsedTranslation()
    {
        $fileRow = array_search($this->fetched, $this->availableTranslations);

        return $this->importer->getTranslations()[$fileRow][1];
    }

}
