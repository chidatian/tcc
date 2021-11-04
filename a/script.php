#!/usr/bin/php
<?php

require_once __DIR__ . '/errors/set_exception_handler.php';

require_once __DIR__ . '/Autoload.php';

$classMap = include_once(__DIR__ . '/classmap.php');

new \A\Autoload($classMap);

\A\Logger::init(dirname(__DIR__).'/a.log');

(new Scripter($argv))->run();

