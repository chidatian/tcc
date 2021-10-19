<?php

namespace A\Errors\Exceptions;

use A\Errors\ErrorInterface;

class JsonException extends ExceptionBase implements ErrorInterface
{
    public function handle()
    {
        header('content-type:application/json');
        $this->message = json_encode([
            'code' => $this->getCode(),
            'msg' => $this->getMessage(),
        ]);
        throw $this;
    }
}