<?php

class Mysql
{
    protected $link = null;

    public function __construct($conf)
    {
        $this->link = @\mysqli_connect($conf->ip, $conf->username, $conf->password, $conf->db, $conf->port);
        // $this->link = @\mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);
        if (!$this->link) {
            echo \mysqli_connect_errno() . PHP_EOL;
            echo \mysqli_connect_error() . PHP_EOL;
            exit;
        }
    }

    public function __destruct()
    {
        if ($this->link)
            \mysqli_close($this->link);
    }

    public function insert($sql)
    {
        if ( $this->query($sql) ) {
            return \mysqli_insert_id($this->link);
        }
        return false;
    }

    public function update($sql)
    {
        if ( $this->query($sql) ) {
            return \mysqli_affected_rows($this->link);
        }
        return false;
    }
    /**
     * 查询多条
     */
    public function select($sql)
    {
        $result = $this->query($sql);

        $list = array();
        while ( $row = \mysqli_fetch_assoc($result) ) {
            $list[] = $row;
        }
        return $list;
    }
    /**
     * 查询一条
     */
    public function find($sql)
    {
        $result = $this->query($sql);
        return \mysqli_fetch_assoc($result);
    }
    
    protected function query($sql)
    {
        $result = \mysqli_query($this->link, $sql);
        if ( \mysqli_error($this->link) ) {
            throw new \Exception(\mysqli_error($this->link), \mysqli_errno($this->link));
        }

        return $result;
    }
    
    /**
     * 事务
     */
    public function rollback()
    {
        return \mysqli_rollback($this->link);
    }
    public function commit()
    {
        return \mysqli_commit($this->link);
    }
    public function begin()
    {
        // \mysqli_begin_transaction ( \mysqli $link [, int $flags = 0 [, string $name ]] ) : bool
        return \mysqli_begin_transaction($this->link);
    }
    public function autocommit($bool=false)
    {
        return \mysqli_autocommit($this->link, $bool);
    }
}