<?php

require __DIR__.'/loader.php';
require __DIR__.'/err/set_exception_handler.php';
$di = include __DIR__.'/di.php';

$app = new \Tc\Mvc\App($di);
$response = $app->run();
$response->handle();
