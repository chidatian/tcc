<?php

namespace A\Lib;

use Exception;

class Assert {

	/**
	 * 是否为空
	 *
	 * @param mixed $value
	 * @return boolean
	 */
	public static function isEmpty($value) {
		if ( empty($value)) {
			throw new Exception('不能为空', -1);
		}
	}

	/**
	 * 操作失败
	 *
	 * @param mixed $value
	 * @param string $msg
	 * @return void
	 */
	public static function operateError($value, $msg='操作失败') {
		if ( $value === false || $value <= 0) {
			throw new Exception($msg, -1);
		}
	}
}