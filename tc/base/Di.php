<?php

namespace Tc;

/**
 * 容器类 [ 单例 ]
 * 
 */
class Di {
	protected static $_instance 	= null;
	protected $_services		= array();

	/**
	 * 获取实例
	 *
	 * @return Di
	 */
	public static function instance() {
		if ( self::$_instance === null) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * 呼叫一个服务
	 *
	 * @param string $name
	 * @return object
	 */
	public function call(string $name) {
		if ( !isset($this->_services[$name]) ) {
			return null;
		}
		if ( $this->_services[$name]['isShare'] ) {
			return $this->_getShare($name);
		}
		return $this->_get($name);
	}

	/**
	 * 添加一个服务
	 *
	 * @param string $name
	 * @param mixed $closure
	 * @return void
	 */
	public function set(string $name, $closure) {
		$this->_setServices($name, $closure, false, null);
	}

	/**
	 * 获取一个服务
	 *
	 * @param string $name
	 * @return void
	 */
	public function get(string $name) {
		return $this->_get($name);
	}

	/**
	 * 添加一个 单例 服务 
	 *
	 * @param string $name
	 * @param mixed $closure
	 * @return void
	 */
	public function setShare(string $name, $closure) {
		$this->_setServices($name, $closure, true, null);
	}

	/**
	 * 获取一个 单例 服务
	 *
	 * @param string $name
	 * @return object
	 */
	public function getShare(string $name) {
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