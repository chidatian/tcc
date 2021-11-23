<?php

namespace A\Mvc;

use A\Library;

class Model {

	protected $connection = '';
    protected $table = '';

	public function __construct() {
		
	}

	public function __get($name) {

        return Library::getInstance()->get($name);
	}

	public function __call($action, $params) {
		$this->_validate();
		
		array_unshift($params, $this->table);
		
		$dbName = $this->connection;

		return call_user_func_array([$this->$dbName, $action], $params);
	}

	public static function __callStatic($action, $params) {
		$static = new static;

		$static->_validate();

		array_unshift($params, $static->table);
		
		$dbName = $static->connection;
		
		return call_user_func_array([$static->$dbName, $action], $params);
	}

	public function _validate() {
		$mysql = $this->connection;
		if ( !$db = $this->$mysql) {
			throw new \Exception('not found connection');
		}

		if ( empty($this->table) ) {
			throw new \Exception('not found table');
		}
	}

	/**
	 * 表结构缓存
	 * 检验 表结构
	 */
	protected function checkTableInfo() {
		return true;

		$fileName = './cache/db/'.$this->dbName.'/'.$this->table;
		if ( file_exists($fileName)) {
			return file_get_contents($fileName);
		}

		$sql = 'SELECT * FROM INFORMATION_SCHEMA.`COLUMNS` WHERE table_name = "' . $this->table . '"';
        // $sql = 'select * from INFORMATION_SCHEMA.TABLE_CONSTRAINTS where table_name = "members"';

		$dbName = $this->connection;

        $res = $this->$dbName->query($sql);
		
		foreach ( $res as $key=>$value) {

		}
		file_put_contents($fileName, var_export($res, true));
		return $res;
	}

	protected function flushTableInfo() {

	}
}