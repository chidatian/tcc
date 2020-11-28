<?php

use Tc\Err;
use Tc\Err\ErrCode;
use Tc\Err\ErrHandler;
use Tc\Err\SystemErr;
use Tc\Mvc\Controller;
use Tc\Lib\Pagination;

class RpcController extends Controller {
    public function index() {

        ErrHandler::throw(Err::create(ErrCode::NOT_FOUND_ROUTER));
        $this->response->successJson('test');
    }
}