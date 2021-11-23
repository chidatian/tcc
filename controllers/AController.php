<?php

use A\Mvc\Controller;

class AController extends Controller
{
    public function index()
    {
        echo '<pre>';
        var_dump($this->config);
        var_export(new A);
        echo 'aaa';die;
    }
}