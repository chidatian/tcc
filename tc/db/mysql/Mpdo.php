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

    public function query($sql)
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