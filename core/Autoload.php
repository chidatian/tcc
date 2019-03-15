<?php


class Autoload
{
	public static function register()
	{
		self::config();
		spl_autoload_register('Autoload::load');
		spl_autoload_register('Autoload::load2');
		set_exception_handler('Autoload::exception');
		// set_error_handler('Autoload::error');
	}
	// 注册配置文件
	public static function config()
	{
		foreach(CONFIG as $v){
			include_once CONF . $v . '.php';
		}
	}
	// namespace 自动加载
	public static function load2($class)
	{
		$class 	= ROOT . $class . '.php';
		$file 	= str_replace('\\', '/', $class);
		if(file_exists($file)){
			include_once $file;
		}
	}
	// 文件路径自动加载
	public static function load($class)
	{
		$path = [CORE, LIB];
		foreach($path as $v){
			$file = $v . $class . '.php';
			if(file_exists($file)){
				include_once $file;
				break;
			}
		}
	}
	// 自动抛异常
	public static function exception($e)
	{
		Helper::pp([
			'-------------------------' => 'Exception',
	    	'file'		=> $e->getFile(),
	    	'line'		=> $e->getLine(),
			'message'	=> $e->getMessage(),
			'------------------------' => 'Exception',
		]);
	    die;
	}
	// Notice: Undefined variable: aa in D:\www\test\ti\app\admin\controller\IndexController.php on line 11
	public static function error($a, $b, $c, $d)
	{
		Helper::pp([
			'-------------------------'	=> 'Error',
			'代号' => $a,
			'原因' => $b,
			'文件' => $c,
			'行号' => $d,
			'------------------------'	=> 'Error',
		]);
		die;
	}
}