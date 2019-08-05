<?php

/**
 * @author chidatian@126.com
 */
class Model
{
	protected $table 	= '';
	private $tags 		= array('IN' => 'ARRAY', 'NOT IN' => 'ARRAY', 'LT' => '<', 'GT' => '>', 'EQ' => '=', 'NEQ' => '!=', 'BETWEEN' => 'BETWEEN');
	private $pdo		= null;
	private $alias 		= '';
	private $join 		= '';
	private $fields 	= '*';
	private $limit		= '';
	private $where 		= array('string'=>'', 'data'=>array());
	private $data 		= array('string'=>'', 'data'=>array());

	public function __call($methodName, $params)
	{
		$this->instance();
		return $this->$methodName(...$params);
	}

	public static function __callStatic($methodName, $params)
	{
		$mine = new static;
		$mine->instance();
		return $mine->$methodName(...$params);
	}

	protected function join($join)
	{
		$this->join = $join;
		return $this;
	}

	protected function alias($as)
	{
		$this->alias = $as;
		return $this;
	}

	/**
	 * select from 
	 * done
	 */	
	protected function select()
	{
		$sql = 'SELECT ' . $this->fields . ' FROM ' . $this->table . ' ' . $this->alias . ' ';

		if ($this->join != '') {
			$sql .= $this->join;
		}
		if ($this->where['string'] != '') {
			$sql .= 'WHERE ' . $this->where['string'] . ' ';
		}
		if ($this->limit != '') {
			$sql .= $limit;
		}

		return $this->pdo->select($sql, array($this->where['data']));
	}

	/**
	* update where
	* done
	*/
	protected function update()
	{
		$sql = 'UPDATE ' . $this->table . ' ';

		if ($this->where['string'] == '' || $this->data['string'] == '') {
			return false;
		}

		$sql .= 'SET ' . $this->data['string'] . ' ';
		$sql .= 'WHERE ' . $this->where['string'] . ' ';
		$data = $this->where['data'] + $this->data['data'];
		return $this->pdo->update($sql, array($data));
	}

	/**
	* insert into where 插入一条
	* done
	*/
	protected function insert()
	{
		$sql = 'INSERT INTO ' . $this->table . ' ';

		if ($this->data['string'] == '') {
			return false;
		}
		$sql .= 'SET ' . $this->data['string'] . ' ';
		return $this->pdo->update($sql, array($this->data['data']));
	}

	protected function delete()
	{

	}

	protected function data($data = array())
	{
		$tmp = array();
		foreach ($data as $k => $v) {
			$tmp[] = $k . ' = :' . $k;
		}
		$this->data['string'] = implode(',', $tmp);
		$this->data['data']	  = $data;
		return $this;
	}

	/**
     * 预处理执行，创建PDOStatement
     * @param array $where
     */
	protected function where($where = array())
	{
		if ( !is_array($where) ) {
			return false;
		}

		$res = array();
		foreach ($where as $k => $item) {
			if ( !is_array($item) ) {
				$index = $this->whereData($k, $item);
				$res[] = $k . ' = ' . $index . ' ';
			} else {
				$tag = strtoupper($item[0]);
				switch ($this->tags[$tag]) {
					case 'ARRAY' :
						$index = $this->whereData($k, $item[1]);
						$res[] = $k . ' ' . $tag . ' ( ' . implode( ',', $index ) . ' ) ';
						break;
					case 'BETWEEN' :
						$index = $this->whereData($k, $item[1]);
						$res[] = $k . ' ' . $tag . ' ' . implode( ' AND ', $index ) . ' ';
						break;
					default :
						$index = $this->whereData($k, $item[1]);
						$res[] = $k . ' ' . $this->tags[$tag] . ' ' . $index;
				}
			}
		}

		$this->where['string'] = implode(' AND ', $res);
		return $this;
	}

	/**
	* 添加占位符 :name
	* @param string $tag
	* @param array OR string $item
	*/
	private function whereData($tag, $item)
	{
		if (is_array($item)) {
			$res = array();
			foreach ($item as $k => $v) {
				$this->where['data'][$tag.$k] = $this->isString($v);
				$res[] = ':'.$tag.$k;
			}
			return $res;
		} else {
			$this->where['data'][$tag] = $this->isString($item);
			return ':'.$tag;
		}
	}

	/**
	 * 给字符串 添加  "" 双引号 
	 */
	private function isString($item)
	{
		if ( is_array($item) ) {
			foreach ($item as $k => $v) {
				$item[$k] = is_string($v) ? '"' . $v . '"' : $v;
			}
			return $item;
		}
		return is_string($item) ? '"' . $item . '"' : $item;
	}

	protected function field($fields = '*')
	{
		$this->fields = $fields;
		return $this;
	}

	protected function limit($limit = '')
	{
		$this->limit = $limit;
		return $this;
	}

	private function isExitTable()
	{
		if ($this->table == '') {
			echo 'protected $table is null ';
			exit;
		}
	}

	/**
     * 获取数据连接对象
     */
	private function instance()
	{
		$this->isExitTable();

		$this->pdo = MyPDO::instance();
	}
}
