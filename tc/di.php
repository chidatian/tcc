<?php

use Tc\Di;
use Tc\Mvc\Router;

$di = new Di;

$di->setShare('config', function(){
	return new \Tc\Config([
		'REDIS' => [
			'IP' => '127.0.0.1',
			'port' => 6379,
			'auth' => '',
			'select' => 0
		],
		'mysql' => [
			'ip' => '127.0.0.1',
			'port' => 3306,
			'user' => 'root'
		],
		'session' => [
			'type' => 'redis'
		]
	]);
});

$di->setShare('router', function() {
	$router = new Router();
	$router->get('/admin/tc/index', '\App\Admin\Controller\TcController@index');
	$router->get('/admin/tc/sess', '\App\Admin\Controller\TcController@sess');
	$router->get('/index/index', '\IndexController@index');
	$router->get('/index/config', '\IndexController@config');
	return $router;
});

return $di;