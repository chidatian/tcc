<?php

namespace A\Mvc;

use A\Library;

class Controller {
	public function __construct() {

	}

	public function __get($name) {
		
        return Library::getInstance()->get($name);
	}
}