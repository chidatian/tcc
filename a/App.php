<?php

namespace A;

use A\Library;
use A\Http\Cookie;
use A\Http\Request;
use A\Http\Response;
use A\Session\SessionManager;

class App
{
    public function __construct()
    {
		$lib = Library::getInstance();

		$lib->setSingle('request', function() {
			return (new Request())->parse();
		});
		
		$lib->setSingle('cookie', new Cookie());

		$lib->setSingle('response', new Response());

		if ( ! $lib->get('session') ) {
			
			$lib->setSingle('session', function(){
				$switch = isset($this->config->session->switch) ? $this->config->session->switch : 0;
				
				$savepath = isset($this->config->session->savepath) ? $this->config->session->savepath : '';

				return new SessionManager(null,$switch, $savepath);
			});
		}

	}

    public function __get($name)
    {
		return Library::getInstance()->get($name);
    }

	public function run()
    {
		$request  = $this->request;
		$response = $this->response;

		$response->obStart();

		$this->session->start();
		
		// 使用 路由
		if ( $this->router && 
			false !== $routes = $this->router->validate($request->route(), $request->method()) 
		) {
			$request->setController($routes['controller']);
			$request->setAction($routes['action']);
	
			call_user_func([new $routes['controller'], $routes['action']]);
		}
		// 不使用 路由
		else {
			$c = $request->controller();
			$a = $request->action();
			call_user_func([new $c, $a]);
		}

		return $response;
	}
}