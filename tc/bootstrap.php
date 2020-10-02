<?php

require __DIR__.'/loader.php';
$di = include __DIR__.'/di.php';

$app = new \Tc\App($di);
$response = $app->run();

var_dump($response);
