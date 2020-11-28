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

		$stmt = $this->prepare($this->_sql);
		$stmt->execute($map);
		return $this->mpdo->lastInsertId();
	}

    public function update($table, $map) {
		$where = isset($map['conditions']) ? $map['conditions'] : [];

		$bind = $this->_setModifySql($table, $map['data'], $where);
		
		if ( !empty($map['bind'])) {
			$bind = array_merge($bind, $map['bind']);
		}

		$stmt = $this->prepare($this->_sql);
		$stmt->execute($bind);
		return $stmt->rowCount();
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

		$this->_sql .= ' ( '.implode(',', $name).' ) ';
		$this->_sql .= 'VALUES';
		$this->_sql .= ' ( :'.implode(',:', $name).' ) ';
		
	}

	private function _setModifySql($table, $data, $where) {
		$this->_sql = 'UPDATE '.$table;
		$this->_sql .= ' SET ';
		$map = $bind = [];
		foreach ($data as $k => $v) {
			$bind['_TC_'.$k] = $v;
			$map[] = $k.' = :_TC_'.$k;
		}
		$this->_sql .= implode(',',$map);

		if ( !empty($where)) {
			$this->_sql .= ' WHERE ' . $where;
		}

		return $bind;
	}
}