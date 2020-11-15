<?php

use Tc\Mvc\Controller;
use Tc\Lib\Page;

class IndexController extends Controller {
    public function index() {
        $p = $this->request->get('p');
        $page = new Page($p,10);
        $map = [
            'columns' => 'id,user',
            'conditions' => 'id > :id',
            'bind' => [
                'id' => 0
            ],
            // 'bindTypes' => [
            //     'id' => 0,
            // ],
            'group' => '',
            'order' => 'id',
            'limit' => $page->limit(),
        ];
        /* (new Members)->update([
            'user' => 'ddd edit'
        ],[
            'id' => 4
        ]); */
        // $res = Members::find($map);
        $res = (new Members)->findFirst($map);
        foreach($res as $k => $item) {
            var_dump($item);
        }
        echo '<pre>';var_dump(count($res), $res);die;
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