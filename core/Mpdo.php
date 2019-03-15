<?php

declare(strict_types = 1);

class Mpdo
{
    private $host   = DB['host'];
    private $user   = DB['user'];
    private $pass   = DB['pass'];
    private $dbname = DB['db'];
    private $charset= DB['char'];
    private $pdo    = null;
    private $stmt   = null;
    private static $obj = null;

    // 单例模式
    public static function instance()
    {
        if (!self::$obj) {
            self::$obj = new self();
        }
        return self::$obj;
    }

    // 构造方法，创建PDO 对象，连接数据库
    private function __construct()
    {
        $this->connect();
    }

    private function __clone()
    {
        die('[-。-]，不允许 clone ~~~');
    }

    // 获取数据库连接
    private function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
        $this->pdo = new \PDO($dsn, $this->user, $this->pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }

    // 预处理执行，创建PDOStatement
    private function exe(string $sql, array $arr = [[]])
    {
        $this->stmt = $this->pdo->prepare($sql);
        foreach ($arr as $k => $v) {
            foreach ($v as $key => $val) {
                if (is_string($key)) {
                    $this->stmt->bindValue(':' . $key, $val);
                } else {
                    $this->stmt->bindValue($key + 1, $val);
                }
            }
            $this->stmt->execute();
        }
    }

    // select from
    public function select($sql,array $arr = [[]], $num = 2): array
    {
        $this->exe($sql, $arr);
        return $this->stmt->fetchAll($num);
    }

    // insert into
    public function insert($sql,array $arr)
    {
        $this->exe($sql, $arr);
        return $this->pdo->lastInsertId();
    }

    // update set where
    public function update($sql,array $arr)
    {
        $this->exe($sql, $arr);
        return $this->stmt->rowCount();
    }

    // delete from where
    public function delete($sql,array $arr)
    {
        $this->exe($sql, $arr);
        return $this->stmt->rowCount();
    }
}