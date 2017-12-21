<?php

$properties = parse_ini_file('config.ini', true);

foreach ($properties[$properties['runmode']] as $property => $value) {
    define(strtoupper($property), $value);
}

define('RUNMODE', 'dev');

if (RUNMODE === 'dev') {
    // developer mode, testing

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    define('BASE_URL', 'http://localhost/websitetest/');
    define('ENFORCE_HTTPS', false);

    // MySQL db configs
    // db_host, db_name, db_user, db_pass
    define('DB', [
        'host' => '',
        'name' => '',
        'user' => '',
        'pass' => ''
    ]);

    define('TRANSLATE_STRICT_DEFAULT', false);
    define('TRANSLATE_RESOURCE_PATH', 'Core/Resource/Helper/GlobalHelper/Translate/Translations');
    define('TRANSLATE_DEFAULT_LANG', 'en');
    define('TRANSLATE_DEFAULT', [
        'strict' => false,
        'directory' => '',
        'language' => 'en'
    ]);

    define('CONTROLLER_DIRECTORY_FLAT_NUMBER', 4);
    define('CONTROLLER_LOAD_401', 'Core\Endpoint\Error\E401\AuthorizationError\Index\Controller');
    define('REDIRECT_401', 'error/e401/authorization-error');
    define('CONTROLLER_LOAD_403', 'Core\Endpoint\Error\E403\AuthorizationError\Index\Controller');
    define('REDIRECT_403', 'error/e403/access-denied');
    define('CONTROLLER_LOAD_404', 'Core\Endpoint\Error\E404\PageNotFound\Index\Controller');
    define('REDIRECT_404', 'error/e404/page-not-found');

    define('ENDPOINT_TEMPLATE_DIR', 'html');
    define('DEFAULT_TEMPLATE', 'Core/Endpoint/Home/Index/Index/Index/html/default.phtml');
    define('DEFAULT_PAGE_TITLE', 'Test Framework');
    define('DEFAULT_PAGE_ICON', 'media/images/default/page-icon.jpg');
    define('DEFAULT_AUTHORIZATION', 'none');

} else {
    // production mode, live



}
