<?php

namespace App\Services;

class RedisUtil
{
	private static $host = '127.0.0.1';
	private static $port = '6379';
	private static $auth = '';
	private static $db   = '';
	private static $redis= null;

	public static function isExist($value = '')
	{
		$redis = self::connect();
		$bool = $redis->set('as', 'value', array('EX' => 5, 'NX'));
		return $bool;
	}
	/**
	 * redis 链接
	 */
	public static function connect()
	{
		if(self::$redis !== null) {
			return self::$redis;
		}
		$r = new \Redis();
		$r->connect(self::$host, self::$port);
		if(self::$auth != '') {
			$r->auth(self::$auth);
		}
		if(self::$db != '') {
			$r->select(self::$db);
		}
		self::$redis = $r;
		return $r;
	}
}