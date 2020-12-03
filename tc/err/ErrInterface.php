<?php

namespace Tc\Err;

interface ErrInterface {

    /**
     * 抛出异常
     *
     * @return void
     */
    public function handle();

}