<?php

namespace A;

/**
 * 单例
 */
class Lib
{
    protected static $instance = null;
    protected static $services = array();

    public static function getInstance()
    {
        if (is_null(self::$instance) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * 添加到容器
     * $object [是object 类型 为单例] [是 callback 类型 不是单例]
     * @param string $name
     * @param mixed $object
     * @return void
     */
    public function set($name, $object)
    {
        self::$services[$name] = $object;
    }

    /**
     * 获取服务
     *
     * @param string $name
     * @return object 
     */
    public function get($name)
    {
        if ( !isset(self::$services[$name]) ) {
            // throw new \Exception("ERROR: service [$name] is not exists");
            return null;
        }
        if ( is_callable(self::$services[$name])) {
            return (self::$services[$name])();
        }
        return self::$services[$name];
    }
    
    protected function __construct()
    {
        
    }
    protected function __clone()
    {
        
    }

}