<?php

namespace app\admin\controller;
use Db;
use app\model\Record;

class IndexController
{
	public function index()
	{
		echo 'index------------------test';
		pp(CONFIG);
		pp(XML);
		logs('IndexController@index');
		$sql = 'select * from record';
		/* $data = Db::select($sql);
		pp($data); */
		echo '$_GET';
		pp($_GET);
		$re = new Record();
		pp($re);
	}
}