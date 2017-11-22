<?php
namespace Content\Resource\Helper\GlobalHelper\Translate;

use Content\Page\Request;

class ImportTranslation
{

    private $_request;

    /**
     * @var array $_data csv data
     */
    protected $_data = [];


    public function __construct(Request $request)
    {
        $this->_request = $request;
    }


    /**
     * @return array All available translation strings
     */
    public function getTranslations()
    {
        if (!$this->_data) $this->runImport();

        return $this->_data;
    }


    /**
     * Main method for import
     *
     * Importing Translations/*.csv file content as array to property $_data
     */
    public function runImport()
    {
        $csv = file_get_contents($this->getCsvPath());
        $this->parseData($csv);
    }


    /**
     * Parse / Convert .csv file into multidimensional array
     */
    protected function parseData(string $csv)
    {
        $data = [];
        $rows = explode("\n", $csv);

        foreach ($rows as $row)
        {
            $dataEntry = explode('","', $row);
            $data[] = $this->adjustDataEntry($dataEntry);
        }

        $this->_data = $data;
    }


    /**
     * Trim data entries by double quotes
     */
    protected function adjustDataEntry(array $entry)
    {
        if (!array_filter($entry)) return [];

        $toShort = strlen($entry[1]) - strrpos($entry[1], '"');
        $adjusted = [
            substr($entry[0], 1),
            substr($entry[1], 0, strlen($entry[1]) - $toShort)
        ];

        return $adjusted;
    }


    /**
     * @return string path according to requested translation file
     */
    public function getCsvPath()
    {
        $filePath = TRANSLATE_RESOURCE_PATH . "/{$this->_request->getLanguage()}.csv";

        if (!file_exists($filePath))
        {
            $filePath = TRANSLATE_RESOURCE_PATH . "/" . TRANSLATE_DEFAULT_LANG . ".csv";
        }

        return $filePath;
    }

}
