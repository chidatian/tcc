<?php

require './loader.php';
$di = include './di.php';

$app = new \Tc\App($di);
$response = $app->run();

var_dump($response);
