<?php

use Tc\Mvc\Controller;

class IndexController extends Controller {
    public function index() {
        return (new Members)->find();
        $res = $this->request->controller();
        return [$res];

    }
}