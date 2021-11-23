<?php

require_once ROOT_PATH . '/a/Autoload.php';

$classMap = include_once(ROOT_PATH . '/a/classmap.php');

(new \A\Autoload($classMap))->registerDirs([
    ROOT_PATH . '/controllers/',
    ROOT_PATH . '/models/'
]);



