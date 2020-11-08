<?php

namespace Tc\Mvc;

use Tc\Di;

class Controller {
	public function __construct() {

	}

	public function __get($name) {
		if ( $obj = Di::instance()->call($name) ) {
			return $obj;
		}
	}
}