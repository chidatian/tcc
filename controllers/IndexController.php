<?php

use Tc\Mvc\Controller;
use Tc\Lib\Page;

class IndexController extends Controller {
    public function index() {
        $p = $this->request->get('p');
        $page = new Page($p,10);
        $map = [
            'columns' => 'id,user',
            'conditions' => 'id > 0',
            // 'bind' => [
            //     'id' => 0
            // ],
            // 'bindTypes' => [
            //     'id' => 0,
            // ],
            'group' => '',
            'order' => 'user',
            'limit' => $page->limit(),
        ];
        /* (new Members)->update([
            'user' => 'ddd edit'
        ],[
            'id' => 4
        ]); */
        $res = Members::find($map);
        // $res = (new Members)->findFirst($map);
        var_dump($res);die;
        $ret = $page->format($res,97);
        $this->response->successJson($ret);
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