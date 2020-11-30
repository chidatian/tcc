<?php

namespace Tc\Mvc;

use Tc\E;
use Tc\Di;
use Tc\Session;
use Tc\Session\FileSessionHandler;
use Tc\Http\Cookie;
use Tc\Http\Request;
use Tc\Http\Response;

class App {
	public function __construct($di) {
		
		$di->setShare('request', function() {
			return new Request();
		});

		$di->setShare('response', function() {
			return new Response();
		});

		$di->call('session') || $di->setShare('session', function() {
			return new Session();
		});

		$di->setShare('cookie', function() {
			return new Cookie();
		});
	}

	public function __get($name) {
		if ( $obj = Di::instance()->call($name) ) {
			return $obj;
		}
	}

	public function run() {

		$request  = $this->request;
		$response = $this->response;

		$response->obStart();

		if ($this->config->session->switch) {

			if ( $this->config->session->savepath) {
				$this->session->setSavePath($this->config->session->savepath);
			}

			$this->session->start();
		}
		
		// 使用 路由
		if ( $this->router && 
			false !== $routes = $this->router->validate($request->route(), $request->method()) 
		) {
			$request->setController($routes['controller']);
			$request->setAction($routes['action']);
	
			call_user_func([new $routes['controller'], $routes['action']]);
		}
		// 不使用 路由
		else {
			$c = $request->controller();
			$a = $request->action();
			call_user_func([new $c, $a]);
		}

		return $response;
	}
}