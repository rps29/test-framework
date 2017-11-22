<?php

$properties = parse_ini_file('config.ini', true);

foreach ($properties[$properties['runmode']] as $property => $value)
{
    define(strtoupper($property), $value);
}

ini_set('display_errors', DISPLAY_ERRORS);

error_reporting(ERROR_REPORTING);
