<?php

namespace A;

class Config {
	
	/**
	 * 构造
	 *
	 * @param mixed $conf
	 */
	public function __construct($conf) {
		if ( is_array($conf)) {

			foreach ($conf as $key => $item) {
				$this->$key = $item;
			}
		} 
		
		else {
			$array = parse_ini_file($conf, true, INI_SCANNER_RAW);
			
			foreach ($array as $key => $item) {
				$this->$key = $item;
			}
		}
	}
}