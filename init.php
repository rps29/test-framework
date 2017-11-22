<?php
/**
 * Initialize global methods
 */


/**
 * Autoload register
 *
 * Using Dependency Injector
 *
 * autoload(string $class);
 * inject(string $class);
 */
require_once "Content/Resource/Helper/GlobalHelper/Autoloader/autoload.php";


/**
 * TODO: Custom Error Handler
 *
 * Error handling
 */
#require_once "Content/Resource/ErrorHandling/handle.php";


/**
 * url()
 *
 * GlobalHelper url(string, string = "");
 *
 * Use for any url endpoints in order to display correct final url redirectable by .htaccess, Index.php and global purl()
 * Parameter two is supposed to be used for special source urls e.g. image locations, css file locations, etc
 */
require_once "Content/Resource/Helper/GlobalHelper/UrlBuilder/url.php";


/**
 * trans()
 *
 * GlobalHelper trans(string $toTranslate);
 *
 * Use for a string being translated depending on current language
 */
require_once "Content/Resource/Helper/GlobalHelper/Translate/trans.php";
