<?php

use Tc\Mvc\Controller;

class IndexController extends Controller {
    public function index() {
        $get = $this->request->get();
        var_dump($get);die;
        $map = [
            'columns' => 'id',
            'conditions' => 'id = :id',
            'bind' => [
                'id' => 2
            ]
        ];
        /* (new Members)->update([
            'user' => 'ddd edit'
        ],[
            'id' => 4
        ]); */

        // $res = Members::findFirst($map);
        $res = (new Members)->findFirst($map);
        $this->response->json($res);
    }

    public function config() {
        var_dump($this->config->redis->ip);die;
    }

    public function mysql() {
        [
            'id' => 1,
            'name' => 'aaa'
        ];
    }
}