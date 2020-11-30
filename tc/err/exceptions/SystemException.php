<?php

namespace Tc\Err\Exceptions;

use Tc\Err\ErrInterface;

/**
 * 框架系统 [10000 - 11000]
 */
class SystemException extends \Exception implements ErrInterface{

    public function __construct($code, $msg)
    {
        $this->code     = $code;
        $this->message  = $msg;
    }
    
    public function handle() {
        throw $this;
    }
    
}