<?php

return [
    "\A\App" => __DIR__ . '/App.php',
    "\A\Autoload" => __DIR__ . '/Autoload.php',
    "\A\Config" => __DIR__ . '/Config.php',
    "\A\Library" => __DIR__ . '/Library.php',
    "\A\Logger" => __DIR__ . '/Logger.php',
    // http
    "\A\Http\Cookie" => __DIR__ . '/http/Cookie.php',
    "\A\Http\Request" => __DIR__ . '/http/Request.php',
    "\A\Http\Response" => __DIR__ . '/http/Response.php',
    // session
    "\A\Session\FileSessionHandler" => __DIR__ . '/session/FileSessionHandler.php',
    "\A\Session\RedisSessionHandler" => __DIR__ . '/session/RedisSessionHandler.php',
    "\A\Session\SessionManager" => __DIR__ . '/session/SessionManager.php',
    //mvc
    "\A\Mvc\Controller" => __DIR__ . '/mvc/Controller.php',
    "\A\Mvc\Model" => __DIR__ . '/mvc/Model.php',
    "\A\Mvc\Router" => __DIR__ . '/mvc/Router.php',
    // error
	'\A\Errors\Error'				=> __DIR__.'/errors/Error.php',
	'\A\Errors\ErrorCode'		=> __DIR__.'/errors/ErrorCode.php',
	'\A\Errors\ErrorHandler'	=> __DIR__.'/errors/ErrorHandler.php',
	'\A\Errors\ErrorInterface'	=> __DIR__.'/errors/ErrorInterface.php',
	'\A\Errors\Exceptions\ExceptionBase'		=> __DIR__.'/errors/exceptions/ExceptionBase.php',
	'\A\Errors\Exceptions\SystemException'	=> __DIR__.'/errors/exceptions/SystemException.php',
	'\A\Errors\Exceptions\JsonException'	=> __DIR__.'/errors/exceptions/JsonException.php',
	// db
	'\A\Db\Mysql\Orm' 			=> __DIR__.'/db/mysql/Orm.php',
	'\A\Db\Mysql\Mpdo' 	=> __DIR__.'/db/mysql/Mpdo.php',
	'\A\Db\Mysql\Mresult' 	=> __DIR__.'/db/mysql/Mresult.php',
    // lib
	'\A\Lib\Pagination' 	=> __DIR__.'/lib/Pagination.php',

];