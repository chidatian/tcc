<?php


if(!function_exists('pp')){
	function pp($val)
	{
		Helper::pp($val);
	}
}
if(!function_exists('dd')){
	function dd($val)
	{
		Helper::dd($val);
	}
}
if(!function_exists('logs')){
	function logs($content, $file = 'logs.log')
	{
		Log::write($content, $file);
	}
}