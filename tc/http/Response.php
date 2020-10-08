<?php

namespace Tc\Http;

class Response {
    public function __construct() {
        ob_start();
    }

	public function handle() {
        ob_end_flush();
    }
    
    public function json($result = [], $code = 200, $msg = 'ok', $page = []) {
        header('content-type:application/json');
        print json_encode($this->_output($result, $code, $msg, $page));
    }

    protected function _output($result = [], $code = 200, $msg = 'ok', $page = []) {
        $ret = [];
        $ret['code'] = $code;
        $ret['msg']  = $msg;
        if ($result) {
            $ret['result'] = $result;
        }
        if ($page) {
            $ret['page'] = $page;
        }
        return $ret;
    }
}