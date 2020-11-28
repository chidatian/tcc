<?php

namespace Tc;

use Tc\Err\ErrCode;

/**
 * 工厂 
 */
class Err {

    public static function create($code, $msg='未知错误') {
        $err = null;
        $msg = ErrCode::$MAP[$code] ?? $msg;
        $class = '\Tc\Err\SystemErr';

        if ( $code > 10000 && $code < 11000) {
            $class = '\Tc\Err\SystemErr';
        }

        $err = new $class($code,$msg);

        return $err;
    }

}