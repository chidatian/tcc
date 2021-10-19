<?php

namespace A\Errors;

interface ErrorInterface {

    /**
     * 抛出异常
     *
     * @return void
     */
    public function handle();

}