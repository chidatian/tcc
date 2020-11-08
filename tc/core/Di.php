<?php

namespace Tc;

class Di {
	protected static $_instance 	= null;
	protected $_services		= array();

	public static function instance() {
		if ( self::$_instance === null) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

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
		$this->_setServices($name, $closure, false, null);
	}

	public function get($name) {
		return $this->_get($name);
	}

	public function setShare($name, $closure) {
		$this->_setServices($name, $closure, true, null);
	}

	public function getShare($name) {
		return $this->_getShare($name);
	}

	protected function _setServices($name, $closure, $isShare, $instanceShare) {
		$this->_services[$name] = array(
			'closure' 		=> $closure,
			'isShare' 		=> $isShare,
			'instanceShare' => $instanceShare
		);
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
			return $this->_services[$name]['instanceShare'] = call_user_func($this->_services[$name]['closure']);
		}
		return $this->_services[$name]['closure'];
	}

	protected function __clone() {}

    protected function __construct() {}

	public function __destruct() {
		self::$_instance = null;
	}
}