<?php

use Tc\Mvc\Controller;

class IndexController extends Controller {
    public function index() {
        $get = $this->request->get();
        $map = [
            'columns' => 'id,user',
            'conditions' => 'id = :id',
            'bind' => [
                'id' => 3
            ]
        ];
        /* (new Members)->update([
            'user' => 'ddd edit'
        ],[
            'id' => 4
        ]); */

        $res = Members::find($map);
        // $res = (new Members)->findFirst($map);
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