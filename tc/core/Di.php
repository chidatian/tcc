<?php

namespace Tc;

class Di {
	protected static $_di 		= null;
	protected $_services		= array();

	public function call($name) {
		if ( !isset($this->_services[$name]) ) {
			return null;
		}
		if ( $this->_services[$name]['isShare'] ) {
			return $this->_getShare($name);
		}
		return $this->_get($name);
	}

	public function set($name, $closure) {
		$this->_services[$name] = array(
			'closure' 		=> $closure,
			'isShare' 		=> false,
			'instanceShare' => null
		);
	}

	public function get($name) {
		return $this->_get($name);
	}

	public function setShare($name, $closure) {
		$this->_services[$name] = array(
			'closure' 		=> $closure,
			'isShare' 		=> true,
			'instanceShare' => null
		);
	}

	public function getShare($name) {
		return $this->_getShare($name);
	}

	protected function _get($name) {
		if ( is_callable($this->_services[$name]['closure']) ) {
			return ($this->_services[$name]['closure'])();
		}
		return $this->_services[$name]['closure'];
	}

	protected function _getShare($name) {
		if ( isset($this->_services[$name]['instanceShare']) ) {
			return $this->_services[$name]['instanceShare'];
		}
		if ( is_callable($this->_services[$name]['closure']) ) {
			return $this->_services[$name]['instanceShare'] = ($this->_services[$name]['closure'])();
		}
		return $this->_services[$name]['closure'];
	}

	public static function getDi() {
		return self::$_di;
	}

	public static function setDi($di) {
		if ( self::$_di === null) {
			self::$_di = $di;
		}
	}

	public function __destruct() {
		self::$_di = null;
	}
}