<?php


class Helper
{
	public static function pp($val)
	{
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	}

	public static function dd($val)
	{
		echo '<pre>';
		var_dump($val);
		echo '</pre>';
	}
}