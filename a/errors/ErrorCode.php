<?php

namespace A\Errors;

class ErrorCode {

    const NOT_FOUND_ROUTER      = 10001;
    const NOT_FOUND_CONTROLLER  = 10002;
    const NOT_FOUND_ACTION      = 10003;
    const MYSQL_CONNECTION_FAILED = 10004;

    public static $MAP = [
        self::NOT_FOUND_ROUTER => '路由不存在 ',
    ];

}