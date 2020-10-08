<?php

namespace Tc\Session;

class RedisSessionHandler implements \SessionHandlerInterface
{
    private $savePath;
    private $redis;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function open($savePath, $sessionName)
    {
        /* $this->savePath = $savePath;
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0777);
        } */
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('123456');
        $redis->select(0);
        $this->redis = $redis;
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($id)
    {
        // return (string)@file_get_contents("$this->savePath/sess_$id");
        return $this->redis->get("sess_$id");
    }
    
    public function write($id, $data)
    {
        // return file_put_contents("$this->savePath/sess_$id", $data) === false ? false : true;
        return $this->redis->set("sess_$id", $data);
    }

    public function destroy($id)
    {
        /* $file = "$this->savePath/sess_$id";
        if (file_exists($file)) {
            unlink($file);
        } */
        $this->redis->delete("sess_$id");

        return true;
    }

    public function gc($maxlifetime)
    {
        /* foreach (glob("$this->savePath/sess_*") as $file) {
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                unlink($file);
            }
        } */

        return true;
    }
}