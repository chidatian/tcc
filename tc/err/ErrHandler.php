<?php

namespace Tc\Err;

use Tc\ErrInterface;

class ErrHandler {

    public static function throw(ErrInterface $e) {
        $e->handle();
    }


    
}