<?php
require_once "config.php";
require_once "init.php";

inject('\Content\Page\EndpointControlling\Controller')->run();

inject('\Content\Page\RenderObject')->render();

#var_dump($injector->_loaded);
#var_dump($_GET);