<?php

use Tc\Err;
use Tc\Err\ErrCode;
use Tc\Err\ErrHandler;
use Tc\Mvc\Controller;
use Tc\Lib\Pagination;
use Tc\Lib\Assert;

class RpcController extends Controller {
    public function index() {
    	Assert::operateError(0);
        ErrHandler::throw(Err::create(ErrCode::NOT_FOUND_ROUTER));
        $this->response->successJson('test');
    }
}