<?php

namespace A\Http;

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
    
    public function setJsonHeader() {
        header('content-type:application/json');
    }

    public function successJson($result = []) {
        print $this->output($result, 200, 'success');
    }

    public function errorJson($result = []) {
        print $this->output($result, 500, 'error');
    }

    public function json($result = [], $code = 200, $msg = 'success') {
        print $this->output($result, $code, $msg);
    }

    protected function output($result, $code, $msg) {
        $this->setJsonHeader();
        $ret = [];
        $ret['code'] = $code;
        $ret['msg']  = $msg;
        if ($result) {
            $ret['result'] = $result;
        }
        return json_encode($ret);
    }
}