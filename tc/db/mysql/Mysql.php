<?php

namespace Tc\Db;

use Tc\Db\Mysql\Mpdo;
use Tc\Db\Mysql\Mresult;

/**
 * orm
 */
class Mysql
{
    protected $mpdo = null;
    protected $stmt = null;
    protected $_sql = '';

    public function __construct($config) {
        $this->mpdo = new Mpdo($config);
	}

    public function prepare($sql) {
        return $this->mpdo->prepare($sql);
	}

	/**
	 * 原生sql
	 */
	public function query($sql,$bind=[]) {
		if ( empty($bind)) {
			$stmt = $this->mpdo->query($sql);
			return (new Mresult($stmt));
		}

		else {
			return $this->prepareQuery($sql, $bind);
		}
	}

    public function prepareQuery($sql,$bind) {
        
        $stmt = $this->prepare($sql);
		$stmt->execute($bind);
		return (new Mresult($stmt));
        // return $stmt->fetchAll(2);
    }

	/**
	 * 获取一条
	 */
    public function findFirst($table, $map) {
        $this->_setQuerySql($table, $map);
        $this->_sql .= ' LIMIT 1 ';

        if ( empty($map['bind'])) {
			$stmt = $this->query($this->_sql);
			return (new Mresult($stmt, true));
        }
        return $this->prepareQuery($this->_sql, $map['bind']);
    }
	
	/**
	 * 获取多条
	 */
    public function find($table, $map) {
		$this->_setQuerySql($table, $map);
		
		if ( isset($map['limit']) && !empty($map['limit'])) {
			$this->_sql .= ' LIMIT '.$map['limit'];
		}
        if ( empty($map['bind'])) {
            return $this->query($this->_sql);
        }
        return $this->prepareQuery($this->_sql, $map['bind']);
	}
	
    public function create($table, $map) {
		$this->_setInsertSql($table, $map);

		return $this->mpdo->insert($this->_sql);
	}

    public function update($table, $map) {
		$where = $map['conditions'] ?? [];
		$this->_setModifySql($table, $map['data'], $where);

		return $this->mpdo->update($this->_sql);
	}

    public function save($table, $map) {

	}

    private function _setQuerySql($table, $map) {
        $this->_sql = 'SELECT ';
        
		if ( isset($map['columns']) && !empty($map['columns'])) {
			$this->_sql .= $map['columns'];
		} else {
			$this->_sql .= ' * ';
		}
		
        $this->_sql .= ' FROM '.$table;
        
		if ( isset($map['conditions']) && !empty($map['conditions'])) {
            $this->_sql .= ' WHERE '.$map['conditions'];
		}

		if ( isset($map['group']) && !empty($map['group'])) {
			$this->_sql .= ' GROUP BY '.$map['group'];
		}

		if ( isset($map['order']) && !empty($map['order'])) {
			$this->_sql .= ' ORDER BY '.$map['order'];
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
		
		if ( !empty($where)) {
			$map = [];
			foreach ($where as $k => $v) {
				$v = is_string($v) ? '"'.$v.'"' : $v;
				$map[] = $k.' = '.$v;
			}
			$this->_sql .= ' WHERE ';
			$this->_sql .= implode(' AND ', $map);
		}
	}
}