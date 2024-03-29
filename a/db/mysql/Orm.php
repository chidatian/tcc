<?php

namespace A\Db\Mysql;

/**
 * orm
 */
class Orm
{
    protected $mpdo = null;
    protected $mresult = null;
    protected $lastInsertId = null;
    protected $rowCount = null;
    protected $_sql = '';

    public function __construct($config) {
        $this->mpdo = new Mpdo($config['ip'],$config['port'],$config['username'],$config['password'],$config['database']);
	}

	public function __destruct()
	{
		$this->mpdo = null;
	}

	/**
	 * 预处理 
	 *
	 * @param string $sql
	 * @return pdostatement
	 */
    public function prepare(string $sql) {
        return $this->mpdo->prepare($sql);
	}

	/**
	 * 原生 sql
	 *
	 * @param string $sql
	 * @return Mresult
	 */
	public function query(string $sql) {
		$stmt = $this->mpdo->query($sql);
		$this->mresult = new Mresult($stmt);
		return $this;
	}

	/**
	 * 预处理 sql
	 *
	 * @param string $sql
	 * @param array $bind
	 * @return Mresult
	 */
    public function prepareQuery(string $sql,array $bind) {
        
        $stmt = $this->prepare($sql);
		$stmt->execute($bind);
		$this->mresult = new Mresult($stmt);
		return $this;
        // return $stmt->fetchAll(2);
    }

	public function count() {
		return count($this->mresult);
	}

	public function get() {
		return $this->mresult;
	}

	/**
	 * 获取一条
	 *
	 * @param string $table 表名
	 * @param array $map
	 * @return Mresult
	 */
    public function findFirst(string $table, array $map = []) {
        $this->_setQuerySql($table, $map);
        $this->_sql .= ' LIMIT 1 ';

        if ( empty($map['bind'])) {
			$stmt = $this->mpdo->query($this->_sql);
			// return (new Mresult($stmt, true));
			$this->mresult = new Mresult($stmt, true);
			return $this;
        }
		// 预处理
		$stmt = $this->prepare($this->_sql);
		$stmt->execute($map['bind']);
		$this->mresult = new Mresult($stmt, true);
		return $this;
    }

	public function save(array $map) {

	}
	
	/**
	 * 获取多条
	 *
	 * @param string $table 表名
	 * @param array $map
	 * @return void
	 */
    public function find(string $table, array $map = []) {
		$this->_setQuerySql($table, $map);
		
		if ( isset($map['limit']) && !empty($map['limit'])) {
			$this->_sql .= ' LIMIT '.$map['limit'];
		}
        if ( empty($map['bind'])) {
            return $this->query($this->_sql);
        }
        return $this->prepareQuery($this->_sql, $map['bind']);
	}

	/**
	 * 添加一条
	 *
	 * @param string $table
	 * @param array $map
	 * @return int 插入的 id
	 */
    public function create(string $table, array $map) {
		$this->_setInsertSql($table, $map);

		$stmt = $this->prepare($this->_sql);
		$stmt->execute($map);
		$this->lastInsertId =  $this->mpdo->lastInsertId();
		return $this;
	}
	
	public function lastInsertId() {
		return $this->lastInsertId;
	}

	public function rowCount() {
		return $this->rowCount;
	}

	/**
	 * 修改一条
	 *
	 * @param string $table
	 * @param array $map
	 * @return int 受影响的行数
	 */
    public function update(string $table, array $map) {
		$where = isset($map['conditions']) ? $map['conditions'] : [];

		$bind = $this->_setModifySql($table, $map['data'], $where);
		
		if ( !empty($map['bind'])) {
			$bind = array_merge($bind, $map['bind']);
		}

		$stmt = $this->prepare($this->_sql);
		$stmt->execute($bind);
		$this->rowCount = $stmt->rowCount();
		return $this;
	}

	// 组装 语句
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

	// 组装 语句
	private function _setInsertSql($table, $data) {
		$this->_sql = 'INSERT INTO '.$table;
		$name = array_keys($data);

		$this->_sql .= ' ( '.implode(',', $name).' ) ';
		$this->_sql .= 'VALUES';
		$this->_sql .= ' ( :'.implode(',:', $name).' ) ';
		
	}

	// 组装 语句
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