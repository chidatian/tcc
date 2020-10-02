<?php

require './core/Loader.php';
$classmap = include './classmap.php';
$loader = new \Tc\Loader($classmap);

//

$loader->registerDirs([
    dirname(__DIR__) . '/controllers/',
    dirname(__DIR__) . '/models/'
]);

$loader->registerNamespaces([
    '\App\Admin\Controller' => dirname(__DIR__) . '/app/admin/controller/'
]);