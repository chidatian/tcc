<?php

namespace Tc\Err;

use Tc\ErrInterface;

class SystemErr extends \Exception implements ErrInterface{

    public function __construct($code, $msg)
    {
        $this->code     = $code;
        $this->message  = $msg;
    }
    
    public function handle() {
        throw new self($this->code, $this->message, null);
    }
    
}