<?php

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
    $traceStr = $e->getTraceAsString();
    $file = $e->getFile();
    $line = $e->getLine();

    switch ($class) {
        case 'JsonException':
            echo $msg;
            break;
        default:
            echo "ERROR: [ $class ] [ $code ] [ $msg ] [ $file($line) ] " . PHP_EOL;
            echo $traceStr;
    }
});
