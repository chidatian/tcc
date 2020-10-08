<?php

use Tc\Mvc\Controller;

class IndexController extends Controller {
    public function index() {
        $res = (new Members)->find();
        $this->response->json($res);
    }

    public function config() {
        var_dump($this->config->redis->ip);die;
    }
}