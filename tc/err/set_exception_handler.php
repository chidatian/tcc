<?php

use Tc\Di;

/**
 * 抛异常统一处理
 * 
 */
set_exception_handler(function($e) {
    
    $class = get_class($e);
    if ( strpos($class, '\\') !== false ) {
        $tmp = explode('\\', $class);
        $class = array_pop($tmp);
    }

    $code = $e->getCode();
    $msg  = $e->getMessage();
    $file = $e->getFile();
    $line = $e->getLine();
    $traceStr = "[{$class}]".$e->getTraceAsString();
    $traceArr = $e->getTrace();

    switch ($class) {
        case 'JsonException':
            Di::instance()->call('response')->json([],$code,$msg);
            break;
        default:
            Di::instance()->call('response')->json($traceStr,$code,$msg);
    }
});
