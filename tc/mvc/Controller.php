<?php

namespace Tc\Mvc;

class Controller {
	protected $di = null;

	public function __construct($di) {
		$this->di = $di;
	}
}