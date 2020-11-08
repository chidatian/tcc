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

		$di->setShare('session', function() {
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

		$this->session->start();
		
		if ( !$this->router || false === $routes = $this->router->validate(
			$request->route(), 
			$request->method()
		) ) {

			throw new E('[ error : router ]');
		}
		else {
			$request->setController($routes['controller']);
			$request->setAction($routes['action']);
	
			call_user_func([new $routes['controller'], $routes['action']]);
		}

		return $response;
	}
}