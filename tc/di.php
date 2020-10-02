<?php

use Tc\Di;
use Tc\Http\Request;
use Tc\Http\Router;

$di = new Di;

$di->setShare('request', function() {
	return new Request();
});

$di->setShare('router', function() {
	$router = new Router();
	$router->get('/admin/tc/index', '\App\Admin\Controller\TcController@index');
	$router->get('/index/index', '\IndexController@index');
	return $router;
});

return $di;