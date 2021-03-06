<?php

require __DIR__.'/base/Loader.php';

$loader = new \Tc\Loader();

//

$loader->registerDirs([
    __DIR__ . '/lib/',
    __DIR__ . '/rpc/',
    dirname(__DIR__) . '/lib/helpers/',
    dirname(__DIR__) . '/controllers/',
    dirname(__DIR__) . '/models/'
]);

$loader->registerNamespaces([
    '\App\Admin\Controller' => dirname(__DIR__) . '/app/admin/controller/'
]);