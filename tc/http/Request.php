<?php

namespace Tc\Http;

class Request {
	protected $_get 		 = array();
	protected $_post 		 = array();
	protected $_server 		 = array();
	protected $_method		 = '';
	protected $_uri			 = '';
	protected $_route	  	 = '';
	protected $_ip			 = '127.0.0.1';
	protected $_port		 = '80';

	protected $_module		 = 'Index';
	protected $_controller	 = 'IndexController';
	protected $_action		 = 'Index';

	public function __construct() {
		$this->_server 	= $_SERVER;
		$this->_get 	= $_GET;
		$this->_post 	= $_POST;
		$this->_method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : '';
		$this->_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
		$this->_port = isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : '';
		$this->_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $this->_init();
	}

    protected function _init() {
		if ( $p = strpos($this->_uri, '?') ) {
			$uri = strtolower(substr($this->_uri, 1, $p-1));
		} else {
			$uri = strtolower(substr($this->_uri, 1));
		}
		$info = explode('/', $uri);
		if ( isset($info[0]) && $pos = strpos($info[0], '.php') ) {
			if ( substr($info[0], $pos) == '.php' ) {
				unset($info[0]);
			}
		}
		$this->setRoute($info);
		$this->setAction(array_pop($info));
		$this->setController(array_pop($info));
		$this->setModule(array_pop($info));
	}

	protected function setModule($m) {
		$this->_module = $m;
	}

	public function module() {
		return $this->_module;
	}
	
	protected function setController($c) {
		$this->_controller = empty($c) ? '' : ucfirst($c).'Controller';
	}

	public function controller() {
		return $this->_controller;
	}

	protected function setAction($a) {
		$this->_action = $a;
	}

	public function action() {
		return $this->_action;
	}

	protected function setRoute($info) {
		$this->_route = '/'.implode('/', $info);
	}

	public function route() {
		return $this->_route;
	}

	public function port() {
		return $this->_port;
	}

	public function ip() {
		return $this->_ip;
	}

	public function uri() {
		return $this->_uri;
	}

	public function server($key = '', $value = '') {
		if ( $key == '' ) {
			return $this->_server;
		}
		return isset($this->_server[$key]) ? $this->_server[$key] : $value;
	}

	/**
	 * @param mixed $value 默认值
	 */
	public function get($key = '', $value = '') {
		if ( $key == '' ) {
			return $this->_get;
		}
		return isset($this->_get[$key]) ? $this->_get[$key] : $value;
	}

	public function post($key = '', $value = '') {
		if ( $key == '' ) {
			return $this->_post;
		}
		return isset($this->_post[$key]) ? $this->_post[$key] : $value;
	}

	public function isPost() {
		return $this->method() == 'POST' ? true : false;
	}

	public function isGet() {
		return $this->method() == 'GET' ? true : false;
	}

	public function method() {
		return $this->_method;
	}
}