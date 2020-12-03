<?php

namespace Tc;

use Tc\Err\ErrCode;

/**
 * 工厂 
 */
class Err {

    /**
     * 实例化一个异常
     *
     * @param integer $code
     * @param string $msg
     * @return object
     */
    public static function create(int $code, $msg='未知错误') {
        $err = null;
        $msg = ErrCode::$MAP[$code] ?? $msg;
        $class = '\Tc\Err\Exceptions\SystemException';

        if ( $code > 10000 && $code < 11000) {
            $class = '\Tc\Err\Exceptions\SystemException';
        }

        $err = new $class($msg, $code);

        return $err;
    }

}