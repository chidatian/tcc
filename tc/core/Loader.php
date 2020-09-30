<?php

namespace Tc;

class Loader {
	protected $dirs 	= array();
	protected $classmap = array();

	public function __construct($classmap) {
		$this->classmap = $classmap;
		spl_autoload_register([$this, 'tc_loader']);
	}

	public function registerDirs($dirs = []) {
		foreach ($dirs as $k => $item) {
			$this->dirs[] = $item;
		}
	}

	public function tc_loader($class) {
		$filename = $this->classmap[$class];
		if ( file_exists($filename)) {
			include $filename;
		}
	}
}
