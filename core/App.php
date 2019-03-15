<?php


class App
{
	private static $module 		= '';
	private static $controller 	= '';
	private static $action 		= '';
	private static $get = [];

	public static function run()
	{
		// http://www.test.com/two/public/index.php/admin/Index/index
		$tag = true;
		if(isset($_SERVER['PATH_INFO'])){
			$arr = explode('/', $_SERVER['PATH_INFO'], 5);
		}else{
			$arr = explode('/', $_SERVER['QUERY_STRING'], 5);
			if(!empty($arr[0])){
				// http://www.test.com/two/public/?a=admin&b=index&c=index
				$arr = array_values($_GET);
				array_unshift($arr,'');
				$tag = false;
			}
		}
		self::$module 		= $arr[1] ?? MVC['module'];
		self::$controller 	= $arr[2] ?? MVC['controller'];
		self::$action 		= $arr[3] ?? MVC['action'];
		self::$get 			= explode('/', $arr[4] ?? '');
		$tag && self::reload_get();
		self::create();
	}

	private static function create()
	{
		$action 	= strtolower(trim(self::$action));
		$controller = ucfirst(strtolower(trim(self::$controller)));
		$module 	= strtolower(trim(self::$module));
		$namespace 	= '\app\\' . $module . '\controller\\' . $controller . 'Controller';

		if(class_exists($namespace) && method_exists($namespace, $action)){
			$object = new $namespace();
			$object->$action();
		}else{
			echo 'URL something wrong...';
		}
	}

	private static function reload_get()
	{
		$_GET = [];
		if(empty(self::$get[0])) return;
		$keys = array_filter(self::$get, function($k){
			return !($k & 1);
		}, ARRAY_FILTER_USE_KEY);
		$vals = array_filter(self::$get, function($k){
			return ($k & 1);
		}, ARRAY_FILTER_USE_KEY);
		if(count($keys) != count($vals)){
			throw new Exception('URL parameter something wrong...');
		}
		$_GET = array_combine($keys, $vals);
	}
}