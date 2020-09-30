<?php

require './loader.php';
$di = include './di.php';

$app = new \Tc\App($di);
$app->run();
