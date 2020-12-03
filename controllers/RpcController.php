<?php

use Tc\Err;
use Tc\Err\ErrCode;
use Tc\Err\ErrHandler;
use Tc\Mvc\Controller;
use Tc\Lib\Pagination;
use Tc\Lib\Assert;

class RpcController extends Controller {
    public function index() {
        
        $this->response->successJson('test');
    }

    public function err() {
        LogHelper::write('d:/keke/log/test.log', 'test');
        LogHelper::error('d:/keke/log/test.log');
    	Assert::operateError(0);
        ErrHandler::throw(Err::create(ErrCode::NOT_FOUND_ROUTER));
    }
}