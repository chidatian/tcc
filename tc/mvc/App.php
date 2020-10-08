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
		Di::setDi($di);
	}

	public function __get($name) {
		if ( $obj = Di::getDi()->call($name) ) {
			return $obj;
		}
	}

	public function run() {
		$request  = $this->request;
		$response = $this->response;
		$this->session->start();
		$c = $request->controller();
		$a = $request->action();
		if ( $router = $this->router ) {
			if ( false === $c = $router->match($request->route(), $request->method()) ) {
				throw new E('[ error : router ]');
				return $response;
			}
		}
		if ( empty($c) || empty($a)) {
			throw new E('[ empty: controller or action ]');
			return $response;
		}
		call_user_func([new $c, $a]);
		return $response;
	}
}