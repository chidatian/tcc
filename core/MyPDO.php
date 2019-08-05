<?php

/**
 * @author chidatian@126.com
 * 单例模式
 */
class MyPDO
{
    private $host   = DB['host'];
    private $user   = DB['user'];
    private $pass   = DB['pass'];
    private $dbname = DB['db'];
    private $charset= DB['char'];
    private $port   = DB['port'];
    private $pdo    = null;
    private $stmt   = null;
    private static $obj = null;
    
    /**
     * 获取数据连接对象
     */
    public static function instance()
    {
        if (!self::$obj) {
            self::$obj = new self();
        }
        return self::$obj;
    }

    /**
     * 预处理执行，创建PDOStatement
     * @param string $sql  $sql = 'select * from action where id = :id';
     * @param array $arr 二维数组
     */
    private function exe($sql, $arr = [[]])
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

    /**
     * select from
     * @param string $sql  $sql = 'select * from action where id = :id';
     * @param array $arr 二维数组 条件
     */
    public function select($sql, $arr = [[]], $num = 2)
    {
        $this->exe($sql, $arr);
        return $this->stmt->fetchAll($num);
    }
    /**
     * insert into
     * @param string $sql
     * @param array $arr 要插入的数据 
     */
    public function insert($sql, $arr)
    {
        $this->exe($sql, $arr);
        return $this->pdo->lastInsertId();
    }

    /**
     * update set where
     * @param string $sql
     * @param array $arr 二维数组 条件 和要 更新的数据
     */
    public function update($sql, $arr)
    {
        $this->exe($sql, $arr);
        return $this->stmt->rowCount();
    }
    
    /**
     * delete from where
     * @param string $sql
     * @param array $arr 二维数组 条件
     */
    public function delete($sql, $arr)
    {
        $this->exe($sql, $arr);
        return $this->stmt->rowCount();
    }

    /**
     * 构造方法，创建PDO 对象，连接数据库
     */
    private function __construct()
    {
        $this->connect();
    }

    private function __clone()
    {
        die('[-。-]，不允许 clone ~~~');
    }

    /**
     * pdo 连接
     */
    private function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset};port={$this->port}";
        $this->pdo = new \PDO($dsn, $this->user, $this->pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
    }
}