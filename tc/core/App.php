<?php

namespace Tc;

use Tc\Di;

class App {
	public function __construct($di) {
		Di::setDi($di);
	}

	public function __get($name) {
		if ( $obj = Di::getDi()->call($name) ) {
			return $obj;
		}
	}

	public function run() {
		if ( $request = $this->request ) {
			$c = $request->controller();
			$a = $request->action();
			if ( $router = $this->router ) {
				if ( false === $c = $router->match($request->route(), $request->method()) ) {
					return 'error: router';
				}
			}
			return call_user_func([new $c, $a]);
		}
		return null;
	}
}
