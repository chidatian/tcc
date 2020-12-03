<?php

namespace Tc\Err;

use Tc\Err\ErrInterface;

class ErrHandler {

    /**
     * 处理异常
     *
     * @param ErrInterface $e
     * @return void
     */
    public static function throw(ErrInterface $e) {
        $e->handle();
    }


    
}