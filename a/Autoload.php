<?php

namespace A;


class Autoload {
	protected $_classmap	 = array();
	protected $_dirs 	 	 = array();
	protected $_namespaces 	 = array();

	public function __construct($classMap = []) {
		$this->_classmap = $classMap;
		spl_autoload_register([$this, '_loader']);
	}

    protected function _loader($class) {
		$class = '\\'.$class;
		if ( isset($this->_classmap[$class]) ) {
			include $this->_classmap[$class];
		}
	}

	/**
	 * 注册目录
	 *
	 * @param array $dirs
	 * @return void
	 */
	public function registerDirs($dirs = []) {
		foreach ($dirs as $item) {
            if ( !is_string($item)) {
                throw new \Exception('ERROR: autoload register dir is invalid');
            }
            $this->_dirs[] = $item;
		}
		spl_autoload_register([$this, '_loaderDirs']);
        return $this;
	}
    /**
	 * 类名与文件名一样 注意大小写
	 */
	protected function _loaderDirs($class) {
		$class = '\\'.$class;
		$class = substr($class, strrpos($class, '\\')+1);
		foreach ( $this->_dirs as $dir) {
			$filename = $dir . $class . '.php';
			if ( file_exists($filename)) {
				include $filename;
			}
		}
	}

	/**
	 * 注册命名空间
	 *
	 * @param array $namespaces
	 * @return void
	 */
	public function registerNamespaces($namespaces = []) {
		foreach ($namespaces as $k => $item) {
            if (!is_string($item)) {
                throw new \Exception('ERROR: autoload register namespace is invalid');
            }
            $this->_namespaces[$k] = $item;
		}
		spl_autoload_register([$this, '_loaderNamespaces']);
        return $this;
	}

	/**
	 * 类名与文件名一样 注意大小写
	 * App\Admin\Controller\TcController
	 */
	protected function _loaderNamespaces($class) {
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
	
}
