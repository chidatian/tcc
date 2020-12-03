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
	 * @param array $conf
	 */
	public function __construct(array $conf) {
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