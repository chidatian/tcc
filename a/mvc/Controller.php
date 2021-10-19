<?php

namespace Tc\Mvc;

use A\Lib;

class Controller {
	public function __construct() {

	}

	public function __get($name) {
		
        return Lib::getInstance()->get($name);
	}
}