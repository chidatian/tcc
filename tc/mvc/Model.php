<?php

namespace Tc\Mvc;

use Tc\Di;

class Model {
	public function __construct() {

	}

	public function __get($name) {
		if ( $obj = Di::getDi()->call($name) ) {
			return $obj;
		}
	}
}