<?php

namespace A\Errors\Exceptions;

use A\Errors\ErrorInterface;

/**
 * 框架异常 [10000 - 11000]
 */
class SystemException extends ExceptionBase implements ErrorInterface{

	// public Exception::__construct ([ string $message = "" [, int $code = 0 [, Throwable $previous = NULL ]]] )
    
    public function handle() {
        throw $this;
    }
    
}