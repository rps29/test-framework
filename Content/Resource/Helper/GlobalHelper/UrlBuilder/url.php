<?php

/**
 * $argument = [
 *     'first_key' => 'first_value',
 *     'some_id_for_get' => 'second_value'
 * ]
 *
 * @param array $arguments Valid keywords that will be ignored themselves:
 *  - '_lang' => xxx - Changes the language for this URL.
 *    If you add this parameter to the global url() method, the language layer will be changed for all
 *    calls to global url() in the future runtime.
 *  - '_current' => true - Adds all currently requested query parameters for building the URL. This
 *    shouldn't affect future calls to global url() method. Additional parameters passed to url() will
 *    override the currently requested params (if array key is the same).
 *
 * @return Content\Resource\Helper\GlobalHelper\UrlBuilder\UrlBuilder|string
 */
function url(string $resourceUrl = null, array $arguments = [])
{
    try
    {
        return inject('\Content\Resource\Helper\GlobalHelper\UrlBuilder\UrlBuilder')->url($resourceUrl, $arguments);
    }
    catch (Exception $e)
    {
        throw new Exception($e->getMessage());
    }
}
