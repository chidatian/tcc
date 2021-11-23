<?php

require_once __DIR__ . '/errors/set_exception_handler.php';

require_once __DIR__ . '/Autoload.php';

$classMap = include_once(__DIR__ . '/classmap.php');

(new \A\Autoload($classMap))->registerDirs([
    dirname(__DIR__) . '/controllers/',
    dirname(__DIR__) . '/models/'
]);

\A\Library::getInstance()->setSingle('config', new \A\Config(__DIR__ . '/env.ini'));

\A\Logger::init(__DIR__.'/../a.log');
\A\Logger::init(__DIR__.'/../b.log', \A\Logger::DEBUG);


$app = new \A\App;
$response = $app->run();
$response->handle();


