<?php

use Tc\Di;

class LogHelper
{
    /**
     * 写入文件
     *
     * @param string $filename
     * @param mixed $mix
     * @return void
     */
    public static function write(string $filename, $mix) {
        if ( is_array($mix) ) {
            $mix = json_encode($mix);
        }

        else if ( is_object($mix)) {
            $mix = serialize($mix);
        }

        $dir = dirname($filename);
        if ( !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents($filename, $mix.PHP_EOL, FILE_APPEND);
    }

    /**
     * error
     *
     * @param mixed $mix
     * @return void
     */
    public static function error($mix) {
        $config = Di::instance()->call('config');
        if ( file_exists($config->log->error)) {
            $date = date('Y-m-d H:i:s');
            $value = "[{$date}]".$mix;
            self::write($config->log->error, $value);
        }
    }
}