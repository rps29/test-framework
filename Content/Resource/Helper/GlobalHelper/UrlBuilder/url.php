<?php

/**
 * $argument = [
 *     'first_key' => 'first_value',
 *     'some_id_for_get' => 'second_value'
 * ]
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
