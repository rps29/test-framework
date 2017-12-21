<?php
require_once "config.php";
require_once "init.php";

inject('Core\Page\EndpointControlling\Controller')->run();

//var_dump($injector->loaded);
//var_dump($_GET);

/**
 * TODO's:
 *
 * - Remove global helper methods, such as inject(), url(), etc.
 * - Create a 'container'-Class that contains those methods. This will be the base that all other classes must inherit from.
 *
 * - Remove the X-level-directory structure for endpoints and create a module system.
 * - Each module can have multiple endpoints.
 * - Each module can have multiple Views (Block & Template)
 * - Each module can have multiple Models (e.g. for Database actions & more)
 */