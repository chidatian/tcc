<?php

namespace Tc\Db\Mysql;

use ArrayIterator;
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

        return new MysqlResult($result);
    }
    /**
     * 查询一条
     */
    public function findFirst($sql)
    {
        $result = $this->query($sql);
        
        return $result->fetch(PDO::FETCH_ASSOC);
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

class MysqlResult implements \Iterator {
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

	public function __construct($result)
	{
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->array[] = $row;
        }
        $this->rewind();
		// $this->array = $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function toArray() {
		return $this->array;
	}
}