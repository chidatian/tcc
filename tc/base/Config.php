<?php

namespace Tc;

/**
 * 配置文件类
 * 
 */
class Config {
	
	/**
	 * 构造
	 *
	 * @param mixed $conf
	 */
	public function __construct($conf) {
		if ( is_array($conf)) {

			$this->_init($conf, $this);
		} 
		
		else {
			$this->_parseIniFile($conf);
		}
	}

	/**
	 * @param array $conf
	 * @return void
	 */
	protected function _init( array $conf, $that) {
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

	protected function _parseIniFile( string $filename) {
		if ( !file_exists($filename)) {
			throw new \Exception(' ini 文件不存在 ');
		}

		$array = parse_ini_file($filename, true, INI_SCANNER_RAW);
		
		$this->_init($array, $this);
	}
}