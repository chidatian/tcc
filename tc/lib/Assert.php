<?php

namespace Tc\Lib;

use Exception;

class Assert {

	public static function isEmpty($value) {
		if ( empty($value)) {
			throw new Exception('不能为空', -1);
		}
	}

	public static function operateError($value, $msg='操作失败') {
		if ( $value === false || $value <= 0) {
			throw new Exception($msg, -1);
		}
	}
}