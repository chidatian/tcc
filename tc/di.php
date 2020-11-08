<?php

use Tc\Di;
use Tc\Mvc\Router;
use Tc\Db\Mysql;

$di = Di::instance();

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
			'username' => 'root',
			'password' => 'root',
			'db'   => 'tmp',
		],
		'session' => [
			'switch' => true,
			'type'   => 'redis',

		]
	]);
});

$di->setShare('router', function() {
	$router = new Router();
	// $router->get('/admin/tc/index', '\App\Admin\Controller\TcController@index');
	// $router->get('/admin/tc/sess', '\App\Admin\Controller\TcController@sess');
	$router->get('/index/index', '\IndexController@index');
	$router->get('/index/mysql', '\IndexController@mysql');
	// $router->get('/index/config', '\IndexController@config');
	$router->group(['prefix' => '/admin', 'namespace' => '\App\Admin'], function() use ($router){
		$router->group(['prefix' => '/tc', 'namespace' => '\Controller'], function() use ($router){
			$router->match('/index', '\TcController@index',['get','post']);
		});
	});
	// $router->match();
	// echo '<pre>';var_dump($router);die;
	return $router;
});

$di->setShare('tmp', function() use($di) {
	$config = $di->getShare('config')->mysql;
	return new Mysql($config);
});

return $di;