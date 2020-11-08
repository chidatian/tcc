<?php

namespace Tc\Mvc;

use Tc\Di;

class Model {
	protected $dbName 	  = '';
	protected $tableName  = '';

	public function __construct() {

	}

	public function __get($name) {
		if ( $obj = Di::instance()->call($name) ) {
			return $obj;
		}
	}

	public function tableName() {
		return $this->tableName;
	}

	public function dbName() {
		return $this->dbName;
	}

	public function __call($action, $params) {
		$this->_validate();
		
		array_unshift($params, $this->tableName());
		
		$dbName = $this->dbName();

		return call_user_func_array([$this->$dbName, $action], $params);
	}

	public static function __callStatic($action, $params) {
		$static = new static;

		$static->_validate();

		array_unshift($params, $static->tableName());
		
		$dbName = $static->dbName();
		
		return call_user_func_array([$static->$dbName, $action], $params);
	}

	public function _validate() {
		$mysql = $this->dbName;
		if ( !$db = $this->$mysql) {
			throw new \Exception('not found dbName');
		}

		if ( empty($this->tableName) ) {
			throw new \Exception('not found tableName');
		}
	}
}