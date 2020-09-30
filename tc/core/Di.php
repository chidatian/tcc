<?php

namespace Tc;

class Di {
	protected $dict = array();

	public function set($key, $value) {
		$this->dict[$key] = $value;
	}

	public function get($key) {
		if ( isset( $this->dict[$key]) ) {
			if ( is_callable( $this->dict[$key]) ) {
				return ($this->dict[$key])();
			}
			return $this->dict[$key];
		}
		return null;
	}
}