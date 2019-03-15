<?php

class Log
{
    private static $path = LOGS;

    public static function write($content, $file = 'logs.log')
    {
        $filename = self::$path . $file;
        if(!file_exists($filename)){
            // mkdir($filename, 0777, true);
            throw new Exception('[ ' . $file . ' ] not found...');
        }
        $pre = "\n";
        $pre .= date('Y-m-d H:i:s', time());
        $pre .= '---------------------------------------------';
        $pre .= "\n";
        file_put_contents($filename, $pre . $content, FILE_APPEND);
    }
}