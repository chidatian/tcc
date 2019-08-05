<?php

// php.ini
define('INI', [
	'display_errors'	=> true,
	'error_reporting'	=> -1,
	'timezone'			=> 'PRC',
]);

// 数据库
define('DB', [
	'host'	=> '127.0.0.1',
	'user'	=> 'root',
	'pass'	=> 'root',
	'db'	=> 'test',
	'char'	=> 'utf8',
	'port'	=> '3306',
]);

// 默认控制器
define('MVC', [
	'module'		=> 'admin',
	'controller'	=> 'index',
	'action'		=> 'index',
]);

// 注册其他配置 文件，文件必须在conf 文件夹下
define('CONFIG', [
	'wx',
]);