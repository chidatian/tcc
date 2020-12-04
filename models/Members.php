<?php

use Tc\Mvc\Model;

class Members extends Model {
	protected $dbName = 'tmp';
	protected $tableName = 'members';


	public static function findArray($array) {
		$res = self::find($array);
		return $res ? $res->toArray() : [];
	}
}