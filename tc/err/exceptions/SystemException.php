<?php

namespace Tc\Err\Exceptions;

use Tc\Err\ErrInterface;

/**
 * 框架异常 [10000 - 11000]
 */
class SystemException extends ExceptionBase implements ErrInterface{

	// public Exception::__construct ([ string $message = "" [, int $code = 0 [, Throwable $previous = NULL ]]] )
    
    public function handle() {
        throw $this;
    }
    
}