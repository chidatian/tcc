<?php

$classmap = include __DIR__.'/classmap.php';
require __DIR__.'/core/Loader.php';

$loader = new \Tc\Loader($classmap);

//

$loader->registerDirs([
    dirname(__DIR__) . '/controllers/',
    dirname(__DIR__) . '/models/'
]);

$loader->registerNamespaces([
    '\App\Admin\Controller' => dirname(__DIR__) . '/app/admin/controller/'
]);