<?php

namespace Tc;

class Config {
	public function __construct($conf) {
		$this->_init($conf, $this);
	}

	protected function _init($conf, $that) {
		foreach ($conf as $key => $item) {
			$key = strtolower($key);
			if ( is_array($item)) {
				$that->$key = new \stdclass;
				$this->_init($item, $that->$key);
			} else {
				$that->$key = $item;
			}
		}
	}
}