<?php

/**
 * 2020.03.11 chidatian
 * pdo [sqlite mysql]
 */
define('DB_HOST', '192.168.1.86');
define('DB_USER', 'root');
define('DB_PWD', 'admin'); 
define('DB_NAME', 'test');  
define('DB_PORT', '3308');

define('IS_SQLITE', false);
define('DB_SQLITE', 'F:\git\php\mysql\sqlite.db');
class Db
{
    protected $link = null;

    public function __construct()
    {
        if (IS_SQLITE) {
            $this->link = new PDO('sqlite:'.DB_SQLITE);
        } else {
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';port='.DB_PORT.'charset=utf8';
            $this->link = new PDO($dsn, DB_USER, DB_PWD);
        }
        if ( $this->link->errorCode() ) {
            throw new Exception(implode(',', $this->link->errorInfo()));
        }
    }

    public function __destruct()
    {
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

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * 查询一条
     */
    public function find($sql)
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
    public function begin_transaction()
    {
        return $this->link->beginTransaction();
    }
    public function autocommit()
    {
        return $this->link->beginTransaction();
    }
}

$sql = 'select * from g_user';
$sql = 'insert into g_user(username, password) values ("gmail2", "google")';
// $sql = 'update g_user set password = "google2" where id = 5';
$db = new Db;
$db->begin_transaction();
if ( $res = $db->insert($sql) ) {
    $db->commit();
    var_dump($res);
} else {
    $db->rollback();
}

