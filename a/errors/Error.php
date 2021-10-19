<?php

namespace A\Errors;

/**
 * 工厂 
 */
class Error {

    /**
     * 实例化一个异常
     *
     * @param integer $code
     * @param string $msg
     * @return object
     */
    public static function create(int $code, $msg='something wrong') {
        $err = null;
        $msg = ErrorCode::$MAP[$code] ?? $msg;
        $class = '\A\Errors\Exceptions\SystemException';

        if ( $code >= 50000 && $code < 60000) {
            $class = '\A\Errors\Exceptions\JsonException';
        }

        $err = new $class($msg, $code);

        return $err;
    }

}