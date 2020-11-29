<?php

namespace Tc\Err;

use Tc\Err\ErrInterface;

class ErrHandler {

    public static function throw(ErrInterface $e) {
        $e->handle();
    }


    
}