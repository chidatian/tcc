<?php

namespace Tc;

class App {
	protected $di = null;

	public function __construct($di) {
		$this->di = $di;
	}

	public function __get($name) {
		if ( $obj = $this->di->get($name) ) {
			return $obj;
		}
	}

	public function run() {
		var_dump( $this->request->controller());
	}
}
