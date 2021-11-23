<?php

define('ROOT_PATH', dirname(dirname(__DIR__)));

require_once __DIR__ . '/set_exception_handler.php';

require_once __DIR__ . '/autoload.php';

require_once __DIR__ . '/library.php';

require_once __DIR__ . '/database.php';

\A\Logger::init(ROOT_PATH .'/logs/a.log');

$app = new \A\App;
$response = $app->run();
$response->handle();


