<?php

/**
 * Translate by requested language and available translations in properly Translations/*.csv file
 */
function trans(string $toTranslate, bool $strict = TRANSLATE_STRICT_DEFAULT)
{
    try
    {
        return inject('\Content\Resource\Helper\GlobalHelper\Translate\Translator')->trans($toTranslate, $strict);
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }
}
