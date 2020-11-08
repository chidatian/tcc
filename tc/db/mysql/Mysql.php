<?php

namespace Tc\Db;

use Tc\Db\Mysql\Mpdo;

class Mysql
{
    protected $mpdo = null;
    protected $stmt = null;
    protected $_sql = '';

    public function __construct($config) {
        $this->mpdo = new Mpdo($config);
	}

	/**
	 * 原生sql
	 */
	public function query($sql,$bind=[]) {
		if ( empty($bind)) {
            return $this->mpdo->select($sql);
		}

		else {
			return $this->prepareQuery($sql, $bind);
		}
	}

    protected function prepareQuery($sql,$bind) {
        
        $this->stmt = $this->mpdo->prepare($sql);
		$this->stmt->execute($bind);
        return $this->stmt->fetchAll(2);
    }

	/**
	 * 获取一条
	 */
    public function findFirst($table, $map) {
        $this->_setQuerySql($table, $map);
        $this->_sql .= ' LIMIT 1 ';

        if ( empty($map['bind'])) {
            return $this->mpdo->findFirst($this->_sql);
        }
        return $this->prepareQuery($this->_sql, $map['bind']);
    }
	
	/**
	 * 获取多条
	 */
    public function find($table, $map) {
        $this->_setQuerySql($table, $map);

        if ( empty($map['bind'])) {
            return $this->mpdo->select($this->_sql);
        }
        return $this->prepareQuery($this->_sql, $map['bind']);
	}
	
    public function create($table, $map) {
		
	}

    public function update($table, $map) {

	}

    public function save($table, $map) {

	}

    private function _setQuerySql($table, $map) {
        $this->_sql = 'SELECT';
        
		if ( isset($map['columns'])) {
			$this->_sql .= ' '.$map['columns'].' ';
		} else {
			$this->_sql .= ' * ';
		}
		
        $this->_sql .= ' FROM '.$table.' ';
        
		if ( isset($map['conditions']) && !empty($map['conditions'])) {
            $this->_sql .= ' WHERE '.$map['conditions'].' ';
		}
	}

	private function _setInsertSql($table, $data) {
		$this->_sql = 'INSERT INTO '.$table;
		$name = array_keys($data);
		$value = array_values($data);
		foreach ($value as &$item) {
			$item = is_string($item) ? '"'.$item.'"' : $item;
		}

		$this->_sql .= ' ( '.implode(',', $name).' ) ';
		$this->_sql .= 'VALUES';
		$this->_sql .= ' ( '.implode(',', $value).' ) ';
		
	}

	private function _setModifySql($table, $data, $where) {
		$this->_sql = 'UPDATE '.$table;
		$this->_sql .= ' SET ';
		$map = [];
		foreach ($data as $k => $v) {
			$v = is_string($v) ? '"'.$v.'"' : $v;
			$map[] = $k.' = '.$v;
		}
		$this->_sql .= implode(',',$map);
		
		$map = [];
		foreach ($where as $k => $v) {
			$v = is_string($v) ? '"'.$v.'"' : $v;
			$map[] = $k.' = '.$v;
		}
		$this->_sql .= ' WHERE ';
		$this->_sql .= implode(' AND ', $map);
	}
}