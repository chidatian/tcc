<?php

namespace Tc\Lib;

class LogHelper
{
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