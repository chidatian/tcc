<?php

namespace Tc;

class Loader {
	protected $_classmap	 = array();
	protected $_dirs 	 	 = array();
	protected $_namespaces 	 = array();

	public function __construct($classmap) {
		$this->_classmap = $classmap;
		spl_autoload_register([$this, '_tc_loader']);
	}

	public function registerDirs($dirs = []) {
		foreach ($dirs as $item) {
			$this->_dirs[] = $item;
		}
		spl_autoload_register([$this, '_dirs_loader']);
	}

	public function registerNamespaces($namespaces = []) {
		foreach ($namespaces as $k => $item) {
			$this->_namespaces[$k] = $item;
		}
		spl_autoload_register([$this, '_namespaces_loader']);
	}

	/**
	 * 类名与文件名一样 注意大小写
	 * App\Admin\Controller\TcController
	 */
	protected function _namespaces_loader($class) {
		$class = '\\'.$class;
		$pos = strrpos($class, '\\');
		$space = substr($class, 0, $pos);
		$name   = substr($class, $pos+1);
		if ( isset($this->_namespaces[$space]) ) {
			$filename = $this->_namespaces[$space] . $name . '.php';
			if ( file_exists($filename)) {
				include $filename;
			}
		}
	}
	
	/**
	 * 类名与文件名一样 注意大小写
	 */
	protected function _dirs_loader($class) {
		foreach ( $this->_dirs as $dir) {
			$filename = $dir . $class . '.php';
			if ( file_exists($filename)) {
				include $filename;
			}
		}
	}

	protected function _tc_loader($class) {
		$class = '\\'.$class;
		if ( isset($this->_classmap[$class]) ) {
			include $this->_classmap[$class];
		}
	}
}
