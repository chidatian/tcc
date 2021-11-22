<?php

namespace A;

use stdClass;

/**
 * 单例
 */
class Library
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
        $this->setServices($name, $object, false);
    }

    public function setSingle($name, $object)
    {
        $this->setServices($name, $object, true);
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

        if ( self::$services[$name]['isSingle'] ) {
            // is single 
            if ( is_null(self::$services[$name]['instance']) 
                && is_callable(self::$services[$name]['callback']) 
            ) {
                self::$services[$name]['instance'] = (self::$services[$name]['callback'])();
            }
            return self::$services[$name]['instance'];
        }

        // not single
        if ( is_callable(self::$services[$name])) {
            return (self::$services[$name]['callback'])();
        }
        return clone self::$services[$name]['instance'];
    }

    protected function setServices($name, $object, $isSingle)
    {
        if ( is_callable($object) ) {
            self::$services[$name] = array(
                'callback' => $object,
                'instance' => null,
                'isSingle' => $isSingle,
            );
        } else {
            self::$services[$name] = array(
                'callback' => null,
                'instance' => $object,
                'isSingle' => $isSingle,
            );
        }
    }
    
    protected function __construct()
    {
        
    }
    protected function __clone()
    {
        
    }

}