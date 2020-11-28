<?php

use Tc\Di;

/**
 * 抛异常统一处理
 * 
 */
set_exception_handler(function(Exception $e) {
    $code = $e->getCode();
    $msg = $e->getMessage();
    $file = $e->getFile();
    $line = $e->getLine();
    $trace = $e->getTraceAsString();
    $class = get_class($e);
    if ( strpos($class, '\\') !== false ) {
        $tmp = explode('\\', $class);
        $class = array_pop($tmp);
    }

    switch ($class) {
        case 'JsonErr':
            Di::instance()->call('response')->json([],$code,$msg);
            break;
        default:
            Di::instance()->call('response')->json($trace,$code,$msg);
    }
});
