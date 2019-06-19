<?php

namespace App\Services;

class LogUtil
{
    public static function write($file, $data = array())
    {
        $info  = date('Y-m-d H:i:s') . "----------------------------------------------------\n";
        if(is_array($data)) {
            $info .= (json_encode($data) . "\n");
        } elseif(is_string($data)) {
            $info .= ($data . "\n");
        } else {
            $info .= (' ( ' . $type . " ) Does not support type\n");
        }
        file_put_contents($file, $info, FILE_APPEND);
    }
}