<?php

namespace A\Errors;

class ErrorHandler {

    /**
     * 处理异常
     *
     * @param ErrorInterface $e
     * @return void
     */
    public static function throw(ErrorInterface $e) {
        $e->handle();
    }


    
}