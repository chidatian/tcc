<?php
/**
 * 命名空间\类名 => 绝对路径
 */
return array(
	// core
	'\Tc\Config'    => __DIR__.'/core/Config.php',
	'\Tc\Di'    	=> __DIR__.'/core/Di.php',
	'\Tc\E'    		=> __DIR__.'/core/E.php',
	'\Tc\Loader' 	=> __DIR__.'/core/Loader.php',
	// db
	'\Tc\Db\Mysql' 	=> __DIR__.'/db/mysql/Mysql.php',
	'\Tc\Db\Mysql\Mpdo' 	=> __DIR__.'/db/mysql/Mpdo.php',
	// mvc
	'\Tc\Mvc\App'    		=> __DIR__.'/mvc/App.php',
	'\Tc\Mvc\Router'    	=> __DIR__.'/mvc/Router.php',
	'\Tc\Mvc\Controller'    => __DIR__.'/mvc/Controller.php',
	'\Tc\Mvc\Model'    		=> __DIR__.'/mvc/Model.php',
	'\Tc\Mvc\View'    		=> __DIR__.'/mvc/View.php',
	// http
	'\Tc\Http\Cookie'    	=> __DIR__.'/http/Cookie.php',
	'\Tc\Http\Request'    	=> __DIR__.'/http/Request.php',
	'\Tc\Http\Response'    	=> __DIR__.'/http/Response.php',
	// session
	'\Tc\Session' 						=> __DIR__.'/session/Session.php',
	'\Tc\Session\FileSessionHandler' 	=> __DIR__.'/session/FileSessionHandler.php',
	'\Tc\Session\RedisSessionHandler' 	=> __DIR__.'/session/RedisSessionHandler.php',
);