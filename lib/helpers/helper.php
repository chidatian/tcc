<?php


if(!function_exists('pp')){
	function pp($val, $return = false)
	{
		return call_user_func('print_r', $val, $return);
	}
}


if(!function_exists('dd')){
	function dd()
	{
		$arr = func_get_args();
		call_user_func_array('var_dump', $arr);
	}
}


if(!function_exists('log')){
	function log()
	{
		$arr = func_get_args();
		call_user_func_array('LogHelper::write', $arr);
	}
}


