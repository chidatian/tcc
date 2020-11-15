<?php

namespace Tc\Db\Mysql;

use PDO;
use Exception;

class Mpdo {
    protected $link = null;
    /* protected static $_instance 	= null;

	public static function instance($config) {
		if ( self::$_instance === null) {
			self::$_instance = new self($config);
		}
		return self::$_instance;
	}
	protected function __clone() {}

	public function __destruct() {
		self::$_instance = null;
	} */

    public function __construct($config) {
        $dsn = 'mysql:host='.$config->ip.';dbname='.$config->db.';port='.$config->port.'charset=utf8';
        $this->link = new PDO($dsn, $config->username, $config->password);
        if ( $this->link->errorCode() ) {
            throw new Exception(implode(',', $this->link->errorInfo()));
        }
    }

    public function insert($sql)
    {
        if ( $this->link->exec($sql) ) {
            return $this->link->lastInsertId();
        }
        return false;
    }

    public function update($sql)
    {
        if ( $res = $this->link->exec($sql) ) {
            return $res;
        }
        return false;
    }
    /**
     * 查询多条
     */
    public function select($sql)
    {
        $result = $this->query($sql);

        return new MysqlResult($result, 0);
    }
    /**
     * 查询一条
     */
    public function findFirst($sql)
    {
        $result = $this->query($sql);
        
        return new MysqlResult($result, 1);
    }

    protected function query($sql)
    {
        $stmt = $this->link->query($sql);

        if ($stmt) {
            return $stmt;
        }
        if ( $this->link->errorCode() ) {
            throw new Exception(implode(',', $this->link->errorInfo()));
        }
    }
    /**
     * 预处理
     */
    public function prepare($sql)
    {
        return $this->link->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    }

    /**
     * 事务
     */
    public function rollback()
    {
        return $this->link->rollBack();
    }
    public function commit()
    {
        return $this->link->commit();
    }
    public function begin()
    {
        return $this->link->beginTransaction();
    }
    public function autocommit()
    {
        return $this->link->beginTransaction();
    }
}

class MysqlResult implements \Iterator, \Countable, \ArrayAccess {
	protected $array = [];
	protected $position = null;
	/* 方法 */
	// abstract public current ( ) : mixed
	public function current ( ) {
		return $this->array[$this->position];
	}
	// abstract public key ( ) : scalar
	public function key ( ) {
		return $this->position;
	}
	// abstract public next ( ) : void
	public function next ( ) {
		$this->position++;
	}
	// abstract public rewind ( ) : void
	public function rewind ( ) {
		$this->position = 0;
	}
	// abstract public valid ( ) : bool
	public function valid ( ) {
		return isset($this->array[$this->position]);
    }
    /* 方法 */
    // abstract public count ( ) : int
    public function count ( ) {
        return count($this->array);
    }
    /* 方法 */
    // abstract public offsetExists ( mixed $offset ) : boolean
    public function offsetExists ( $offset ) {
        return isset($this->array[$offset]);
    }
    // abstract public offsetGet ( mixed $offset ) : mixed
    public function offsetGet ( $offset ) {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }
    // abstract public offsetSet ( mixed $offset , mixed $value ) : void
    public function offsetSet ( $offset , $value ) {
        if (is_null($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }
    // abstract public offsetUnset ( mixed $offset ) : void
    public function offsetUnset ( $offset ) {
        unset($this->array[$offset]);
    }

	public function __construct($result, $isSingleRow = 0)
	{
        if ( $isSingleRow) {
            $this->array = $result->fetch(PDO::FETCH_ASSOC);
            // $result->closeCursor();
        }

        else while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->array[] = $row;
        }
        $this->rewind();
		// $this->array = $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function toArray() {
		return $this->array;
	}
}