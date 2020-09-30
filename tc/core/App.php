<?php

namespace Tc;

class App {
	protected $di = null;

	public function __construct($di) {
		$this->di = $di;
	}

	public function __get($name) {
		echo $name;
	}

	public function run() {
		echo $this->request->controller();
	}
}
