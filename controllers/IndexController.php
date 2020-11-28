<?php

use Tc\Mvc\Controller;
use Tc\Lib\Pagination;

class IndexController extends Controller {
    public function index() {
        $p = $this->request->get('p');
        $page = new Pagination($p,10);
        $map = [
            // 'columns' => 'id,user',
            // 'conditions' => 'id > :id',
            // 'bind' => [
            //     'id' => 5
            // ],
            // 'bindTypes' => [
            //     'id' => 0,
            // ],
            // 'group' => '',
            'order' => 'id DESC',
            // 'limit' => $page->limit(),
        ];
        /* (new Members)->update([
            'user' => 'ddd edit'
        ],[
            'id' => 4
        ]); */
        $res = Members::find($map);
        // $res = (new Members)->findFirst($map);
        $this->response->successJson($res->toArray());
        // foreach($res as $k => $item) {
        //     var_dump($item);
        // }
        // echo '<pre>';var_dump(count($res), $res);die;
        // $ret = $page->format($res,97);
        // $this->response->successJson($ret);
    }

    public function config() {
        $res = Members::create([
            'user' => 'chida',
            'passwd' => 'chi"""da"""""'
        ]);
        $this->response->errorJson($res);
        // var_dump($this->config->redis->ip);die;
    }

    public function mysql() {
        $res = Members::update([
            'data' => [
                'passwd' => 'a""a""a"'
            ],
            'conditions' => 'id = :id',
            'bind' => ['id' => 8],
        ]);
        $this->response->json($res, 0);
    }
}