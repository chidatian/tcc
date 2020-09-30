<?php

require './loader.php';
$di = include './di.php';

$a = new \Tc\App($di);
var_dump($a);