<?php

namespace Tc\Http;

class Response {
    public function __construct() {
    }

    public function obStart() {
        ob_start();
    }

    public function obEndFlush() {
        ob_end_flush();
    }

	public function handle() {
        $this->obEndFlush();
    }
    
    public function json() {
        header('content-type:application/json');
    }

    public function successJson($result = []) {
        $this->json();
        print json_encode($this->output($result, 200, 'success'));
    }

    public function errorJson($result = []) {
        $this->json();
        print json_encode($this->output($result, 500, 'error'));
    }

    public function output($result = [], $code = 200, $msg = 'success') {
        $ret = [];
        $ret['code'] = $code;
        $ret['msg']  = $msg;
        if ($result) {
            $ret['result'] = $result;
        }
        return $ret;
    }
}