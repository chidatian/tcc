<?php

class Db
{
    private static $db = null;

    private static function construct()
    {
        self::$db = Mpdo::instance();
    }
    
    public static function select($sql, $data = [])
    {
        self::instance();
        if(count($data) == count($data, 1)){
            return self::$db->select($sql, [$data]);
        }
        return self::$db->select($sql, $data);
    }
    public static function insert($sql, $data)
    {
        self::instance();
        if(count($data) == count($data, 1)){
            return self::$db->insert($sql, [$data]);
        }
        return self::$db->insert($sql, $data);
    }
    public static function update($sql, $data)
    {
        self::instance();
        if(count($data) == count($data, 1)){
            return self::$db->update($sql, [$data]);
        }
        return self::$db->update($sql, $data);
    }
    public static function delete($sql, $data)
    {
        self::instance();
        if(count($data) == count($data, 1)){
            return self::$db->delete($sql, [$data]);
        }
        return self::$db->delete($sql, $data);
    }
    private static function instance()
    {
        if(!isset(self::$db)){
            self::construct();
        }
    }
    private function __clone(){}
    private function __construct(){}
}