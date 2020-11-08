<?php

namespace Tc\Mvc;

use Tc\Di;

class Model {
	protected $dbName 	  = '';
	protected $tableName  = '';

	public function __construct() {
		$this->checkTableInfo();
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

	/**
	 * 表结构缓存
	 * 检验 表结构
	 */
	protected function checkTableInfo() {
		return true;

		$fileName = './cache/db/'.$this->dbName.'/'.$this->tableName;
		if ( file_exists($fileName)) {
			return file_get_contents($fileName);
		}

		$sql = 'SELECT * FROM INFORMATION_SCHEMA.`COLUMNS` WHERE table_name = "' . $this->tableName . '"';
        // $sql = 'select * from INFORMATION_SCHEMA.TABLE_CONSTRAINTS where table_name = "members"';

		$dbName = $this->dbName();

        $res = $this->$dbName->query($sql);
		
		foreach ( $res as $key=>$value) {

		}
		file_put_contents($fileName, var_export($res, true));
		return $res;
	}

	protected function flushTableInfo() {

	}
}