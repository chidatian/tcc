<?php

namespace Tc\Lib;

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

        file_put_contents($filename, $mix, FILE_APPEND);
    }

    
}