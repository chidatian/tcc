<?php


class Phpini
{
	public static function setup()
	{
		ini_set('display_errors', INI['display_errors']);
		error_reporting(INI['error_reporting']);
		date_default_timezone_set(INI['timezone']);
	}
}